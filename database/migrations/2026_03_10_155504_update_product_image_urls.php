<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $images = [
            'Гирос с курицей' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.55%20(1).jpeg',
            'Гирос со свининой' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.55%20(1).jpeg',

            'Люля-кебаб с бараниной' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.55%20(2).jpeg',
            'Люля-кебаб с курицей' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.56.jpeg',
            'Люля-кебаб свино-говяжий' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35%20(2).jpeg',

            'Шашлык из куриного филе' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.27%20(1).jpeg',
            'Шашлык из свиной шеи' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.28%20(1).jpeg',
            'Шашлык из свиного антрекота' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.26.jpeg',
            'Шашлык из свиных рёбер' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35%20(1).jpeg',
            'Шашлык из бараньего антрекота' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.34%20(1).jpeg',

            'Комбо шашлык из свинины' => 'https://ik.imagekit.io/zwejlzoni/IMG_4285.jpg',
            'Комбо Люля-кебаб' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.59.jpeg',
            'Комбо шашлык из курицы' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.58%20(2).jpeg',

            'Сковородка с курицей' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35.jpeg',
            'Сковородка со свининой' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35.jpeg',
            'Скепасти с курицей' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-10%20at%2016.55.46.jpeg',

            'Шаурма со свининой' => 'https://ik.imagekit.io/zwejlzoni/IMG_4432.jpg',
            'Шаурма с курицей' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.57%20(1).jpeg',
            'Шаурма из люля-кебаб' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.58.jpeg',

            'Харчо' => 'https://ik.imagekit.io/zwejlzoni/IMG_4022.jpg',
            'Солянка' => 'https://ik.imagekit.io/zwejlzoni/84a96af0-667d-4ff2-af13-c968c52452ff.webp',

            'Домашние пельмени' => 'https://ik.imagekit.io/zwejlzoni/IMG_4373.jpg',

            'Картофель фри' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.26%20(1).jpeg',
            'Картошка по-деревенски' => 'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.09.jpeg',
        ];

        DB::transaction(function () use ($images) {
            foreach ($images as $title => $imageUrl) {
                DB::table('products')
                    ->where('title', $title)
                    ->update([
                        'image_url' => $imageUrl,
                    ]);
            }
        });
    }

    public function down(): void
    {
        // rollback намеренно пустой:
        // старые image_url не сохранены, безопасно откатить их автоматически нельзя
    }
};
