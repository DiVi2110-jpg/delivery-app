<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    $products = Product::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    return view('welcome', compact('products'));
});

Route::post('/send-order', function (Request $request) {
    $data = $request->validate([
        'cart' => ['required', 'array', 'min:1'],
        'cart.*.product_id' => ['required', 'integer', 'exists:products,id'],
        'cart.*.qty' => ['required', 'numeric', 'min:1'],

        'address' => ['required', 'string', 'min:3'],
        'phone' => ['required', 'string', 'min:5'],
        'comment' => ['nullable', 'string'],
    ]);

    do {
        $orderPublicId = 'ORD-' . Str::upper(Str::random(6));
    } while (Order::query()->where('public_id', $orderPublicId)->exists());

    try {
        $order = DB::transaction(function () use ($data, $orderPublicId) {
            $order = Order::create([
                'public_id' => $orderPublicId,
                'address' => trim($data['address']),
                'phone' => trim($data['phone']),
                'comment' => isset($data['comment']) ? trim($data['comment']) : null,
                'payment_status' => 'pending',
                'status' => 'new',
                'total' => 0,
            ]);

            $total = 0.0;

            foreach ($data['cart'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                $price = (float) $product->price;
                $qty = $item['qty'];

                if (($product->type ?? 'piece') !== 'weight') {
                    $qty = (int) $qty;
                    if ($qty < 1) {
                        $qty = 1;
                    }
                } else {
                    $qty = (float) $qty;
                }

                if (($product->type ?? 'piece') === 'weight') {
                    // цена за 100г, qty = граммы
                    $lineTotal = ($price / 100) * $qty;
                } else {
                    $lineTotal = $price * $qty;
                }

                $lineTotal = round($lineTotal, 2);
                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'title' => $product->title,
                    'amount' => (string) $qty,
                    'unit_price' => $price,
                    'line_total' => $lineTotal,
                ]);
            }

            $order->update([
                'total' => round($total, 2),
            ]);

            return $order;
        });

        return response()->json([
            'status' => 'success',
            'orderPublicId' => $order->public_id,
        ]);
    } catch (\Throwable $e) {
        Log::error('send-order failed', [
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'status' => 'error',
        ], 500);
    }
});

Route::post('/confirm-payment', function (Request $request) {
    $data = $request->validate([
        'orderPublicId' => ['required', 'string', 'max:32'],
    ], [
        'orderPublicId.required' => 'Не найден номер заказа.',
    ]);

    $order = DB::transaction(function () use ($data) {
        $order = Order::query()
            ->where('public_id', $data['orderPublicId'])
            ->lockForUpdate()
            ->first();

        if (! $order) {
            return null;
        }

        // Клиент не подтверждает оплату окончательно.
        // Он только сообщает, что оплатил.
        if ($order->payment_status === 'pending') {
            $order->update([
                'payment_status' => 'claimed',
            ]);
        }

        return $order->fresh();
    });

    if (! $order) {
        return response()->json([
            'status' => 'error',
            'message' => 'Order not found',
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'paymentStatus' => $order->payment_status,
    ]);
});

// Старый endpoint для совместимости
Route::get('/admin/orders/latest-id', function () {
    abort_unless(Filament::auth()->check(), 403);

    return response()->json([
        'latest_id' => (int) (Order::query()->max('id') ?? 0),
    ]);
});

// Новый endpoint для тостов
Route::get('/admin/orders/latest', function () {
    abort_unless(Filament::auth()->check(), 403);

    $o = Order::query()->latest('id')->first();

    return response()->json([
        'id' => (int) ($o?->id ?? 0),
        'public_id' => $o?->public_id,
        'phone' => $o?->phone,
        'total' => (float) ($o?->total ?? 0),
        'created_at' => optional($o?->created_at)->toISOString(),
    ]);
});

Route::get('/admin/orders/{order}/print', function (Order $order) {
    abort_unless(Filament::auth()->check(), 403);

    $order->load('items');

    return view('print.order', compact('order'));
});
