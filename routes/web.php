<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;
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

        'cart' => ['required','array','min:1'],
        'cart.*.product_id' => ['required','integer','exists:products,id'],
        'cart.*.qty' => ['required','numeric','min:1'],

        'address' => ['required','string','min:3'],
        'phone' => ['required','string','min:5'],
        'comment' => ['nullable','string'],

        'orderId' => ['nullable','string']

    ]);

   // ✅ public_id генерим на сервере, чтобы не было коллизий
$orderPublicId = null;
do {
    // пример: ORD-8F3K2A
    $orderPublicId = 'ORD-' . Str::upper(Str::random(6));
} while (\App\Models\Order::query()->where('public_id', $orderPublicId)->exists());

    try {

        $order = DB::transaction(function () use ($data,$orderPublicId) {

            $order = Order::create([
                'public_id' => $orderPublicId,
                'address' => $data['address'],
                'phone' => $data['phone'],
                'comment' => $data['comment'] ?? null,
                'payment_status' => 'pending',
                'status' => 'new',
                'total' => 0
            ]);

            $total = 0.0;

            foreach ($data['cart'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $price = (float) $product->price;
                $qty = $item['qty'];

                // ✅ штучное — целое, вес — float
                if (($product->type ?? 'piece') !== 'weight') {
                    $qty = (int) $qty;
                    if ($qty < 1) $qty = 1;
                } else {
                    $qty = (float) $qty;
                }

                if ($product->type === 'weight') {
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
                    'amount' => $qty,
                    'unit_price' => $price,
                    'line_total' => $lineTotal
                ]);

            }

            $order->update([
                'total' => round($total, 2)
            ]);

            return $order;

        });

        return response()->json([
            'status' => 'success',
            'orderPublicId' => $order->public_id
        ]);

    }
    catch (\Throwable $e) {

        Log::error('send-order failed',[
            'error'=>$e->getMessage()
        ]);

        return response()->json([
            'status'=>'error'
        ],500);

    }

});

Route::post('/confirm-payment', function (Request $request) {
    $data = $request->validate([
        'orderId' => ['required', 'string'],
        'total'   => ['nullable'],
    ]);

    $order = Order::query()
        ->where('public_id', $data['orderId'])
        ->latest('id')
        ->first();

    if (! $order) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Order not found',
        ], 404);
    }

    $order->update([
        'payment_status' => 'paid',
        'paid_at'        => now(),
    ]);

    return response()->json([
        'status' => 'success',
    ]);
});

// ✅ старый endpoint (для совместимости)
Route::get('/admin/orders/latest-id', function () {
    abort_unless(Filament::auth()->check(), 403);

    return response()->json([
        'latest_id' => (int) (Order::query()->max('id') ?? 0),
    ]);
});

// ✅ новый endpoint (для тостов)
Route::get('/admin/orders/latest', function () {
    abort_unless(Filament::auth()->check(), 403);

    $o = Order::query()->latest('id')->first();

    return response()->json([
        'id'         => (int) ($o?->id ?? 0),
        'public_id'  => $o?->public_id,
        'phone'      => $o?->phone,
        'total'      => (float) ($o?->total ?? 0),
        'created_at' => optional($o?->created_at)->toISOString(),
    ]);
});
Route::get('/admin/orders/{order}/print', function (\App\Models\Order $order) {
    abort_unless(Filament::auth()->check(), 403);

    $order->load('items');

    return view('print.order', compact('order'));
});
