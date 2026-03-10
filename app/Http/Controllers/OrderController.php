<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function sendOrder(Request $request, TelegramService $tg)
    {
        $data = $request->validate([
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'cart.*.qty' => ['required', 'numeric', 'min:1'],

            'address' => ['required', 'string', 'min:8', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^(\+7|7|8)\d{10}$/'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ], [
            'cart.required' => 'Корзина пуста.',
            'cart.min' => 'Добавьте хотя бы один товар.',
            'cart.*.product_id.required' => 'Не найден товар в корзине.',
            'cart.*.product_id.exists' => 'Один из товаров больше не существует.',
            'cart.*.qty.required' => 'Не указано количество товара.',
            'cart.*.qty.min' => 'Количество товара должно быть больше нуля.',

            'address.required' => 'Укажите адрес доставки.',
            'address.min' => 'Адрес слишком короткий.',
            'phone.required' => 'Укажите номер телефона.',
            'phone.regex' => 'Введите корректный номер телефона в формате +7XXXXXXXXXX.',
        ]);

        $order = DB::transaction(function () use ($data) {
            $order = new Order();
            $order->public_id = $this->makePublicId();
            $order->address = trim($data['address']);
            $order->phone = trim($data['phone']);
            $order->comment = isset($data['comment']) ? trim($data['comment']) : null;
            $order->payment_status = 'pending';
            $order->status = 'new';
            $order->total = 0;
            $order->save();

            $orderTotal = 0;

            $productIds = collect($data['cart'])
                ->pluck('product_id')
                ->unique()
                ->values();

            $products = Product::query()
                ->whereIn('id', $productIds)
                ->get()
                ->keyBy('id');

            foreach ($data['cart'] as $cartItem) {
                /** @var \App\Models\Product|null $product */
                $product = $products->get((int) $cartItem['product_id']);

                if (!$product) {
                    abort(422, 'Один из товаров не найден.');
                }

                $qty = (float) $cartItem['qty'];
                $type = $product->type ?? 'piece';
                $title = $product->title ?? 'Без названия';
                $price = (float) $product->price;
                $unit = $product->unit ?: 'шт';

                if ($type === 'weight') {
                    $qty = max(100, round($qty / 50) * 50);
                    $amount = (int) $qty . ' г';
                    $unitPrice = (int) round($price) . ' ₽ / 100г';
                    $itemTotal = round(($price / 100) * $qty, 2);
                } else {
                    $qty = max(1, (int) $qty);
                    $amount = $qty . ' ' . $unit;
                    $unitPrice = (int) round($price) . ' ₽';
                    $itemTotal = round($price * $qty, 2);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'title' => $title,
                    'amount' => $amount,
                    'unit_price' => $unitPrice,
                    'total' => $itemTotal,
                ]);

                $orderTotal += $itemTotal;
            }

            $order->total = round($orderTotal, 2);
            $order->save();

            return $order->load('items');
        });

        $text = "🔥 *НОВЫЙ ЗАКАЗ {$order->public_id}* 🔥\n";
        $text .= "⚠️ *СТАТУС: ОЖИДАЕТ ОПЛАТЫ*\n";
        $text .= "➖➖➖➖➖➖➖➖➖➖\n";

        foreach ($order->items as $index => $item) {
            $lineTotal = number_format((float) $item->total, 2, '.', '');
            $orderLine = $index + 1;

            $text .= "{$orderLine}. {$item->title}\n";
            $text .= "└ {$item->amount} • {$item->unit_price} = *{$lineTotal} ₽*\n\n";
        }

        $orderTotalFormatted = number_format((float) $order->total, 2, '.', '');

        $text .= "➖➖➖➖➖➖➖➖➖➖\n";
        $text .= "💰 *К ОПЛАТЕ: {$orderTotalFormatted} ₽*\n";
        $text .= "➖➖➖➖➖➖➖➖➖➖\n";
        $text .= "📍 Адрес: `{$order->address}`\n";
        $text .= "📞 Тел: `{$order->phone}`\n";

        if (!empty($order->comment)) {
            $text .= "💬 Коммент: _" . Str::limit($order->comment, 400) . "_\n";
        }

        $text .= "\n🛑 *НЕ ГОТОВИТЬ ДО ПОДТВЕРЖДЕНИЯ ОПЛАТЫ!*";

        $tg->sendMarkdown($text);

        return response()->json([
            'status' => 'success',
            'orderPublicId' => $order->public_id,
        ]);
    }

    public function confirmPayment(Request $request, TelegramService $tg)
    {
        $data = $request->validate([
            'orderPublicId' => ['required', 'string', 'max:32'],
        ], [
            'orderPublicId.required' => 'Не найден номер заказа.',
        ]);

        $order = Order::query()
            ->where('public_id', $data['orderPublicId'])
            ->firstOrFail();

        if ($order->payment_status === 'pending') {
            $order->payment_status = 'claimed';
            $order->save();
        }

        $orderTotalFormatted = number_format((float) $order->total, 2, '.', '');

        $text = "🚨 *ПРОВЕРКА ОПЛАТЫ {$order->public_id}*\n";
        $text .= "➖➖➖➖➖➖➖➖➖➖\n";
        $text .= "Клиент нажал кнопку «Я оплатил».\n";
        $text .= "Ожидаемая сумма: *{$orderTotalFormatted} ₽*\n\n";
        $text .= "👮‍♂️ *ДЕЙСТВИЯ ПЕРСОНАЛА:*\n";
        $text .= "1) Откройте банк.\n";
        $text .= "2) Найдите входящий перевод на *{$orderTotalFormatted} ₽*.\n";
        $text .= "3) Если пришло — подтвердите в админке.\n\n";
        $text .= "📞 Тел клиента: `{$order->phone}`\n";

        $tg->sendMarkdown($text);

        return response()->json([
            'status' => 'success',
        ]);
    }

    private function makePublicId(): string
    {
        do {
            $num = random_int(1, 999999);
            $publicId = 'PS-' . str_pad((string) $num, 6, '0', STR_PAD_LEFT);
        } while (Order::where('public_id', $publicId)->exists());

        return $publicId;
    }
}
