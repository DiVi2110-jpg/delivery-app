<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');                 // <-- важно
            $table->text('description')->nullable();

            // деньги лучше хранить в копейках/центах (integer)
            $table->unsignedInteger('price')->default(0);

            // тип продукта/позиции (например: piece / weight / portion)
            $table->string('type')->default('piece');

            // единицы (шт., г, кг, мл и т.д.)
            $table->string('unit')->nullable();

            // вес порции (если нужно)
            $table->unsignedInteger('portion_weight')->nullable();

            $table->string('image_url')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
