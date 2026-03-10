<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private function normalizeImageUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        if (str_contains($url, 'www.dropbox.com')) {
            $url = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $url);
        }

        return $url;
    }

    public function run(): void
    {
        $products = [

            ['title'=>'Гирос с курицей','description'=>'Курица, свежие овощи и соус в тёплой лепёшке.','price'=>440,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.55%20(1).jpeg','sort_order'=>1,'is_active'=>true],
            ['title'=>'Гирос со свининой','description'=>'Гирос со свининой, свежими овощами и фирменным соусом.','price'=>420,'type'=>'portion','unit'=>'шт','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.55%20(1).jpeg','sort_order'=>2,'is_active'=>true],

            ['title'=>'Люля-кебаб с бараниной','description'=>'Сочный люля из баранины с пряными специями.','price'=>240,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.55%20(2).jpeg','sort_order'=>3,'is_active'=>true],
            ['title'=>'Люля-кебаб с курицей','description'=>'Нежный и ароматный куриный люля.','price'=>150,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.56.jpeg','sort_order'=>4,'is_active'=>true],
            ['title'=>'Люля-кебаб свино-говяжий','description'=>'С нежным сыром, зеленью и помидорами.','price'=>180,'type'=>'portion','unit'=>'шт','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35%20(2).jpeg','sort_order'=>5,'is_active'=>true],

            ['title'=>'Шашлык из куриного филе','description'=>'Кусочки филе в фирменном маринаде.','price'=>160,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.27%20(1).jpeg','sort_order'=>6,'is_active'=>true],
            ['title'=>'Шашлык из свиной шеи','description'=>'Классика. Сочная свиная шея.','price'=>200,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.28%20(1).jpeg','sort_order'=>7,'is_active'=>true],
            ['title'=>'Шашлык из свиного антрекота','description'=>'Нежный антрекот на мангале.','price'=>180,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.26.jpeg','sort_order'=>8,'is_active'=>true],
            ['title'=>'Шашлык из свиных рёбер','description'=>'Мягкие и сочные ребра с дымком.','price'=>180,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35%20(1).jpeg','sort_order'=>9,'is_active'=>true],
            ['title'=>'Шашлык из бараньего антрекота','description'=>'Нежные кусочки с выразительным вкусом.','price'=>440,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.34%20(1).jpeg','sort_order'=>10,'is_active'=>true],

            ['title'=>'Комбо шашлык из свинины','description'=>'Набор на компанию.','price'=>440,'type'=>'set','unit'=>'сет','portion_weight'=>400,'image_url'=>'https://ik.imagekit.io/zwejlzoni/IMG_4285.jpg','sort_order'=>11,'is_active'=>true],
            ['title'=>'Комбо Люля-кебаб','description'=>'Микс шашлыка и люля.','price'=>450,'type'=>'set','unit'=>'сет','portion_weight'=>400,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.59.jpeg','sort_order'=>12,'is_active'=>true],
            ['title'=>'Комбо шашлык из курицы','description'=>'Куриный шашлык на компанию.','price'=>440,'type'=>'set','unit'=>'сет','portion_weight'=>400,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.58%20(2).jpeg','sort_order'=>13,'is_active'=>true],

            ['title'=>'Сковородка с курицей','description'=>'С овощами под сыром.','price'=>420,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35.jpeg','sort_order'=>14,'is_active'=>true],
            ['title'=>'Сковородка со свининой','description'=>'С овощами и сыром.','price'=>420,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.35.jpeg','sort_order'=>15,'is_active'=>true],
            ['title'=>'Скепасти с курицей','description'=>'Большое блюдо на компанию.','price'=>550,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-10%20at%2016.55.46.jpeg','sort_order'=>16,'is_active'=>true],

            ['title'=>'Хачапури на мангале','description'=>'С сырной начинкой на углях.','price'=>420,'type'=>'piece','unit'=>'шт','portion_weight'=>null,'image_url'=>'https://lefood.menu/wp-content/uploads/w_images/2023/07/recept-79292-1240x827.jpg','sort_order'=>17,'is_active'=>true],

            ['title'=>'Шаурма со свининой','description'=>'Порция около 450г.','price'=>270,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://ik.imagekit.io/zwejlzoni/IMG_4432.jpg','sort_order'=>18,'is_active'=>true],
            ['title'=>'Шаурма с курицей','description'=>'Классика, 450г.','price'=>270,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.57%20(1).jpeg','sort_order'=>19,'is_active'=>true],
            ['title'=>'Шаурма из люля-кебаб','description'=>'Сочная, с люля.','price'=>300,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.58.jpeg','sort_order'=>20,'is_active'=>true],

            ['title'=>'Харчо','description'=>'Пряный, с мясом и рисом.','price'=>330,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/IMG_4022.jpg','sort_order'=>21,'is_active'=>true],
            ['title'=>'Солянка','description'=>'Насыщенная, с оливками.','price'=>320,'type'=>'portion','unit'=>'порция','portion_weight'=>400,'image_url'=>'https://ik.imagekit.io/zwejlzoni/84a96af0-667d-4ff2-af13-c968c52452ff.webp','sort_order'=>22,'is_active'=>true],
            ['title'=>'Суп с фрикадельками','description'=>'Лёгкий, с овощами.','price'=>275,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://static.1000.menu/img/content-v2/a7/fb/59253/sup-iz-krasnoi-chechevicy-s-myasnymi-sharikami_1633459566_7_max.jpg','sort_order'=>23,'is_active'=>true],

            ['title'=>'Домашние пельмени','description'=>'Со сметаной или соусом.','price'=>420,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/IMG_4373.jpg','sort_order'=>24,'is_active'=>true],

            ['title'=>'Салат Крабовый','description'=>'Классический рецепт.','price'=>90,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://static.1000.menu/img/content-v2/be/c8/40643/krabovyi-salat-klassicheskii-bez-risa_1611409506_8_max.jpg','sort_order'=>25,'is_active'=>true],
            ['title'=>'Салат Винегрет','description'=>'Овощной, легкий.','price'=>85,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://vkusnoff.com/img/recepty/4619/big.webp','sort_order'=>26,'is_active'=>true],
            ['title'=>'Салат Витаминка','description'=>'Свежие овощи.','price'=>70,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://media.ovkuse.ru/images/recipes/4036f018-4d91-49c2-b7b2-717ab66330a4/4036f018-4d91-49c2-b7b2-717ab66330a4.jpg','sort_order'=>27,'is_active'=>true],
            ['title'=>'Салат со свёклой','description'=>'Вкусный гарнир.','price'=>70,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://img.iamcook.ru/2017/upl/recipes/cat/u-3f5cbab6d6ca6bf8be38e78c159bcecc.jpg','sort_order'=>28,'is_active'=>true],

            ['title'=>'Картофель фри','description'=>'Хрустящий, горячий.','price'=>115,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.48.26%20(1).jpeg','sort_order'=>29,'is_active'=>true],
            ['title'=>'Картошка по-деревенски','description'=>'Румяная, со специями.','price'=>95,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://ik.imagekit.io/zwejlzoni/WhatsApp%20Image%202025-11-09%20at%2010.47.09.jpeg','sort_order'=>30,'is_active'=>true],
            ['title'=>'Гречка','description'=>'Сытный гарнир.','price'=>120,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://opis-cdn.tinkoffjournal.ru/mercury/in-out-yummy-buckwheat.uk36hgoifwmn..jpg','sort_order'=>31,'is_active'=>true],
            ['title'=>'Рис','description'=>'Универсальный гарнир.','price'=>95,'type'=>'weight','unit'=>'г','portion_weight'=>null,'image_url'=>'https://images.gastronom.ru/loCBqRdFjtGCKOZvc4X3e_7AosC6U-HkvPphb33duuk/pr:article-preview-image/g:ce/rs:auto:0:0:0/L2Ntcy9hbGwtaW1hZ2VzL2U5N2RmMTQ1LWE0MzItNGE1Ny1hM2E2LTc0Y2JiODdjMjI4ZS5qcGc.webp','sort_order'=>32,'is_active'=>true],

            ['title'=>'Добрый 0.33','description'=>'Банка.','price'=>120,'type'=>'drink','unit'=>'0.33л','portion_weight'=>null,'image_url'=>'https://tornado.shop/images/detailed/56/2.jpg','sort_order'=>33,'is_active'=>true],
            ['title'=>'Кока-кола (стекло)','description'=>'Классика.','price'=>130,'type'=>'drink','unit'=>'бутылка','portion_weight'=>null,'image_url'=>'https://tornado.shop/images/detailed/83/80e94788c9f0d3410e340cbd3a699841.jpg','sort_order'=>34,'is_active'=>true],
            ['title'=>'Алазани фейхоа','description'=>'Газировка.','price'=>145,'type'=>'drink','unit'=>'бутылка','portion_weight'=>null,'image_url'=>'https://tornado.shop/images/detailed/84/P1803270.jpg','sort_order'=>35,'is_active'=>true],
            ['title'=>'Алазани тархун','description'=>'Газировка.','price'=>145,'type'=>'drink','unit'=>'бутылка','portion_weight'=>null,'image_url'=>'https://tornado.shop/images/detailed/93/P1914358.PNG','sort_order'=>36,'is_active'=>true],
            ['title'=>'Алазани апельсин','description'=>'Газировка.','price'=>145,'type'=>'drink','unit'=>'бутылка','portion_weight'=>null,'image_url'=>'https://tornado.shop/images/detailed/84/P1803275.jpg','sort_order'=>37,'is_active'=>true],
            ['title'=>'Алазани груша','description'=>'Газировка.','price'=>145,'type'=>'drink','unit'=>'бутылка','portion_weight'=>null,'image_url'=>'https://tornado.shop/images/detailed/93/P1914372.PNG','sort_order'=>38,'is_active'=>true],
            ['title'=>'Добрый кола 1л','description'=>'Большая бутылка.','price'=>155,'type'=>'drink','unit'=>'1л','portion_weight'=>null,'image_url'=>'https://fatcatpizza.ru/pictures/product/big/4560_big.jpg','sort_order'=>39,'is_active'=>true],
        ];

        foreach ($products as $product) {
            $product['image_url'] = $this->normalizeImageUrl($product['image_url'] ?? null);

            Product::updateOrCreate(
                ['title' => $product['title']],
                $product
            );
        }
    }
}
