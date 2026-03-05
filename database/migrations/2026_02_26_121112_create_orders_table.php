<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // публичный номер заказа, который уходит в Telegram и клиенту
            $table->string('public_id')->unique();

            $table->string('address');
            $table->string('phone');
            $table->text('comment')->nullable();

            // total также в копейках (integer)
            $table->unsignedInteger('total')->default(0);

            // pending / paid / failed и т.п.
            $table->string('payment_status')->default('pending');

            // new / cooking / delivered / canceled и т.п.
            $table->string('status')->default('new');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
