<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Checking connections...\n";

$mysql = DB::connection('mysql');
$pgsql = DB::connection('render_pgsql');

$mysql->getPdo();
$pgsql->getPdo();

echo "Connections OK\n\n";

echo "Cleaning target tables in Render Postgres...\n";
$pgsql->statement('TRUNCATE TABLE order_items, orders, products RESTART IDENTITY CASCADE');
echo "Target tables cleaned\n\n";

$tables = [
    'products',
    'orders',
    'order_items',
];

foreach ($tables as $table) {

    echo "Copying table: $table\n";

    $rows = $mysql->table($table)->get();

    foreach ($rows as $row) {
        $pgsql->table($table)->insert((array) $row);
    }

    echo "Copied ".count($rows)." rows\n\n";
}

echo "Fixing sequences...\n";

$pgsql->statement("SELECT setval(pg_get_serial_sequence('products', 'id'), COALESCE((SELECT MAX(id) FROM products), 1), true)");
$pgsql->statement("SELECT setval(pg_get_serial_sequence('orders', 'id'), COALESCE((SELECT MAX(id) FROM orders), 1), true)");
$pgsql->statement("SELECT setval(pg_get_serial_sequence('order_items', 'id'), COALESCE((SELECT MAX(id) FROM order_items), 1), true)");

echo "Sequences fixed\n\n";
echo "Transfer complete\n";
