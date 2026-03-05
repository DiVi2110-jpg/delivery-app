<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->default(0)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2)->change();
            $table->decimal('line_total', 10, 2)->change();
            // amount оставляем как есть (у тебя qty может быть граммы/шт) — ок.
        });
    }

    public function down(): void {}
};
