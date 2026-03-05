<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private function normalizeImageUrl(?string $url): ?string
    {
        if (!$url) return null;

        // Dropbox -> прямая ссылка
        if (str_contains($url, 'www.dropbox.com')) {
            $url = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $url);
        }

        return $url;
    }

    public function run(): void
    {
        $products = [

            // 1–2 Гирос
            ['title'=>'Гирос с курицей','description'=>'Курица, свежие овощи и соус в тёплой лепёшке.','price'=>440,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://www.dropbox.com/scl/fi/6o25f3aagxxm1phi6164o/WhatsApp-Image-2025-11-09-at-10.47.55-1.jpeg?raw=1','sort_order'=>1,'is_active'=>true],
            ['title'=>'Гирос со свининой','description'=>'Гирос со свининой, свежими овощами и фирменным соусом.','price'=>420,'type'=>'portion','unit'=>'шт','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/6o25f3aagxxm1phi6164o/WhatsApp-Image-2025-11-09-at-10.47.55-1.jpeg?raw=1','sort_order'=>2,'is_active'=>true],

            // 3–5 Люля
            ['title'=>'Люля-кебаб с бараниной','description'=>'Сочный люля из баранины с пряными специями.','price'=>240,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/g8aoplnne5last5irbe41/WhatsApp-Image-2025-11-09-at-10.47.55-2.jpeg?raw=1','sort_order'=>3,'is_active'=>true],
            ['title'=>'Люля-кебаб с курицей','description'=>'Нежный и ароматный куриный люля.','price'=>150,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/03jv9ts7ksnuhh7bg01vt/WhatsApp-Image-2025-11-09-at-10.47.56.jpeg?raw=1','sort_order'=>4,'is_active'=>true],
            ['title'=>'Люля-кебаб свино-говяжий','description'=>'С нежным сыром, зеленью и помидорами.','price'=>180,'type'=>'portion','unit'=>'шт','portion_weight'=>null,'image_url'=>'https://dl.dropboxusercontent.com/scl/fi/3piae2k5p4agrxr1dt934/IMG_4212.jpg?raw=1','sort_order'=>5,'is_active'=>true],

            // 6–10 Шашлык
            ['title'=>'Шашлык из куриного филе','description'=>'Кусочки филе в фирменном маринаде.','price'=>160,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/wf97fu22rsbp6o7s2mt8q/WhatsApp-Image-2025-11-09-at-10.48.27-1.jpeg?raw=1','sort_order'=>6,'is_active'=>true],
            ['title'=>'Шашлык из свиной шеи','description'=>'Классика. Сочная свиная шея.','price'=>200,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/uj2xvrqqoau9vdz0jjx00/WhatsApp-Image-2025-11-09-at-10.48.28-1.jpeg?raw=1','sort_order'=>7,'is_active'=>true],
            ['title'=>'Шашлык из свиного антрекота','description'=>'Нежный антрекот на мангале.','price'=>180,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/192tle3vnbhi0j1c9e4yf/WhatsApp-Image-2025-11-09-at-10.48.26.jpeg?raw=1','sort_order'=>8,'is_active'=>true],
            ['title'=>'Шашлык из свиных рёбер','description'=>'Мягкие и сочные ребра с дымком.','price'=>180,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/dr1mdpao6fnvkqfci8ykg/WhatsApp-Image-2025-11-09-at-10.48.35-1.jpeg?raw=1','sort_order'=>9,'is_active'=>true],
            ['title'=>'Шашлык из бараньего антрекота','description'=>'Нежные кусочки с выразительным вкусом.','price'=>440,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/wg9ghl623rzzgv14a044s/WhatsApp-Image-2025-11-09-at-10.48.34-1.jpeg?raw=1','sort_order'=>10,'is_active'=>true],

            // 11–13 Комбо
            ['title'=>'Комбо шашлык из свинины','description'=>'Набор на компанию.','price'=>440,'type'=>'set','unit'=>'сет','portion_weight'=>400,'image_url'=>'https://www.dropbox.com/scl/fi/g0bzztj685pqd16zaoeun/IMG_4285.jpg?raw=1','sort_order'=>11,'is_active'=>true],
            ['title'=>'Комбо Люля-кебаб','description'=>'Микс шашлыка и люля.','price'=>450,'type'=>'set','unit'=>'сет','portion_weight'=>400,'image_url'=>'https://www.dropbox.com/scl/fi/jfo7nhzen53jakw8kjtta/IMG_4311.jpg?raw=1','sort_order'=>12,'is_active'=>true],
            ['title'=>'Комбо шашлык из курицы','description'=>'Куриный шашлык на компанию.','price'=>440,'type'=>'set','unit'=>'сет','portion_weight'=>400,'image_url'=>'https://www.dropbox.com/scl/fi/zt27fk26irtmlvd9zgkn3/24bc5e4d-4fac-472a-a610-509a582620d2_328x170.jpg?raw=1','sort_order'=>13,'is_active'=>true],

            // 14–16 Горячее
            ['title'=>'Сковородка с курицей','description'=>'С овощами под сыром.','price'=>420,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/ask1f2uopyd9qxux4y3s1/WhatsApp-Image-2025-11-09-at-10.48.35.jpeg?raw=1','sort_order'=>14,'is_active'=>true],
            ['title'=>'Сковородка со свининой','description'=>'С овощами и сыром.','price'=>420,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/ask1f2uopyd9qxux4y3s1/WhatsApp-Image-2025-11-09-at-10.48.35.jpeg?raw=1','sort_order'=>15,'is_active'=>true],
            ['title'=>'Скепасти с курицей','description'=>'Большое блюдо на компанию.','price'=>550,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/im8ry9bb91twzrhhufjex/WhatsApp-Image-2025-11-10-at-16.55.46.jpeg?raw=1','sort_order'=>16,'is_active'=>true],

            // 17 Хачапури
            ['title'=>'Хачапури на мангале','description'=>'С сырной начинкой на углях.','price'=>420,'type'=>'piece','unit'=>'шт','portion_weight'=>null,'image_url'=>'https://lefood.menu/wp-content/uploads/w_images/2023/07/recept-79292-1240x827.jpg','sort_order'=>17,'is_active'=>true],

            // 18–20 Шаурма
            ['title'=>'Шаурма со свининой','description'=>'Порция около 450г.','price'=>270,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://www.dropbox.com/scl/fi/uum8jpm6wh4rwosk8dqp8/IMG_4432.jpg?raw=1','sort_order'=>18,'is_active'=>true],
            ['title'=>'Шаурма с курицей','description'=>'Классика, 450г.','price'=>270,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://www.dropbox.com/scl/fi/v1u2tdykg784yyhz7gbzz/WhatsApp-Image-2025-11-09-at-10.47.57.jpeg?raw=1','sort_order'=>19,'is_active'=>true],
            ['title'=>'Шаурма из люля-кебаб','description'=>'Сочная, с люля.','price'=>300,'type'=>'portion','unit'=>'шт','portion_weight'=>450,'image_url'=>'https://www.dropbox.com/scl/fi/0dykf2qbys0sr323zafo4/WhatsApp-Image-2025-11-09-at-10.47.58.jpeg?raw=1','sort_order'=>20,'is_active'=>true],

            // 21–23 Супы
            ['title'=>'Харчо','description'=>'Пряный, с мясом и рисом.','price'=>330,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/8d66glq1wgc4stl7igzvr/IMG_4022.jpg?raw=1','sort_order'=>21,'is_active'=>true],
            ['title'=>'Солянка','description'=>'Насыщенная, с оливками.','price'=>320,'type'=>'portion','unit'=>'порция','portion_weight'=>400,'image_url'=>'https://www.dropbox.com/scl/fi/degx85l8tc4917bcjllfq/84a96af0-667d-4ff2-af13-c968c52452ff.webp?raw=1','sort_order'=>22,'is_active'=>true],
            ['title'=>'Суп с фрикадельками','description'=>'Лёгкий, с овощами.','price'=>275,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://static.1000.menu/img/content-v2/a7/fb/59253/sup-iz-krasnoi-chechevicy-s-myasnymi-sharikami_1633459566_7_max.jpg','sort_order'=>23,'is_active'=>true],

            // 24 Горячее
            ['title'=>'Домашние пельмени','description'=>'Со сметаной или соусом.','price'=>420,'type'=>'portion','unit'=>'порция','portion_weight'=>null,'image_url'=>'https://www.dropbox.com/scl/fi/04b3937gvx75vdpugdgi1/IMG_4373.jpg?raw=1','sort_order'=>24,'is_active'=>true],

            // 25–28 Салаты
            ['title'=>'Салат Крабовый','description'=>'Классический рецепт.','price'=>90,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://static.1000.menu/img/content-v2/be/c8/40643/krabovyi-salat-klassicheskii-bez-risa_1611409506_8_max.jpg','sort_order'=>25,'is_active'=>true],
            ['title'=>'Салат Винегрет','description'=>'Овощной, легкий.','price'=>85,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://vkusnoff.com/img/recepty/4619/big.webp','sort_order'=>26,'is_active'=>true],
            ['title'=>'Салат Витаминка','description'=>'Свежие овощи.','price'=>70,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://media.ovkuse.ru/images/recipes/4036f018-4d91-49c2-b7b2-717ab66330a4/4036f018-4d91-49c2-b7b2-717ab66330a4.jpg','sort_order'=>27,'is_active'=>true],
            ['title'=>'Салат со свёклой','description'=>'Вкусный гарнир.','price'=>70,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://img.iamcook.ru/2017/upl/recipes/cat/u-3f5cbab6d6ca6bf8be38e78c159bcecc.jpg','sort_order'=>28,'is_active'=>true],

            // 29–32 Гарниры
            ['title'=>'Картофель фри','description'=>'Хрустящий, горячий.','price'=>115,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://dl.dropboxusercontent.com/scl/fi/zpgeswy5rqsc54lr6kd5j/WhatsApp-Image-2025-11-09-at-10.48.26-1.jpeg?raw=1','sort_order'=>29,'is_active'=>true],
            ['title'=>'Картошка по-деревенски','description'=>'Румяная, со специями.','price'=>95,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://dl.dropboxusercontent.com/scl/fi/44xssy30vx5maa4leh696/WhatsApp-Image-2025-11-09-at-10.47.09-1.jpeg?raw=1','sort_order'=>30,'is_active'=>true],
            ['title'=>'Гречка','description'=>'Сытный гарнир.','price'=>120,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://opis-cdn.tinkoffjournal.ru/mercury/in-out-yummy-buckwheat.uk36hgoifwmn..jpg','sort_order'=>31,'is_active'=>true],
            ['title'=>'Рис','description'=>'Универсальный гарнир.','price'=>95,'type'=>'weight','unit'=>'100г','portion_weight'=>null,'image_url'=>'https://images.gastronom.ru/loCBqRdFjtGCKOZvc4X3e_7AosC6U-HkvPphb33duuk/pr:article-preview-image/g:ce/rs:auto:0:0:0/L2Ntcy9hbGwtaW1hZ2VzL2U5N2RmMTQ1LWE0MzItNGE1Ny1hM2E2LTc0Y2JiODdjMjI4ZS5qcGc.webp','sort_order'=>32,'is_active'=>true],

            // 33–39 Напитки
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
