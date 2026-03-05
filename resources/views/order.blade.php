<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Печать заказа {{ $order->public_id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        h1 { margin: 0 0 6px; font-size: 22px; }
        .muted { color: #666; font-size: 12px; }
        .row { display:flex; gap:24px; margin-top: 10px; }
        .box { border:1px solid #ddd; padding:12px; border-radius:8px; flex:1; }
        table { width:100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom:1px solid #eee; padding:8px; text-align:left; font-size: 13px; }
        th { background:#fafafa; }
        .total { font-size: 18px; font-weight: 800; margin-top: 10px; }
        @media print {
            button { display:none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

<button onclick="window.print()">🖨️ Печать</button>

<h1>Заказ {{ $order->public_id }}</h1>
<div class="muted">
    Создан: {{ optional($order->created_at)->timezone('Europe/Moscow')->format('d.m.Y H:i') }} (МСК)
</div>

<div class="row">
    <div class="box">
        <div><b>Телефон:</b> {{ $order->phone }}</div>
        <div><b>Адрес:</b> {{ $order->address }}</div>
        <div><b>Комментарий:</b> {{ $order->comment ?: '—' }}</div>
    </div>

    <div class="box">
        <div><b>Оплата:</b> {{ $order->payment_status }}</div>
        <div><b>Статус:</b> {{ $order->status }}</div>
        <div class="total">Итого: {{ number_format((float)$order->total, 2, '.', ' ') }} ₽</div>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Позиция</th>
        <th>Кол-во</th>
        <th>Цена</th>
        <th>Сумма</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->items as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->amount }}</td>
            <td>{{ number_format((float)$item->unit_price, 2, '.', ' ') }} ₽</td>
            <td>{{ number_format((float)$item->line_total, 2, '.', ' ') }} ₽</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    // авто-диалог печати можно включить если хочешь:
    // window.onload = () => window.print();
</script>
</body>
</html>
