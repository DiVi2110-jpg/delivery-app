<!DOCTYPE html>
<html lang="ru" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProШашлык — Доставка шашлыка в Краснодаре</title>
    <meta name="description" content="Сочный шашлык, люля и гирос с доставкой по Краснодару.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (
            localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-enter { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        .menu-item {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .menu-item .px-1 {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
        }

        .menu-item__bottom {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 12px;
        }
    </style>
</head>

<body class="min-h-screen w-full bg-gray-50 dark:bg-[#050505] text-gray-900 dark:text-white font-sans antialiased transition-colors duration-500">

@php
    /** @var \Illuminate\Support\Collection|\App\Models\Product[] $products */
    $products = $products ?? collect();
@endphp

<div class="fixed inset-0 z-0">
    <img src="/images/bg.jpg"
         class="w-full h-full object-cover transition-opacity duration-500 opacity-20 dark:opacity-40 scale-105"
         alt="Background">
    <div class="absolute inset-0 bg-gradient-to-b from-white/90 via-white/70 to-white/95 dark:from-black/90 dark:via-black/50 dark:to-[#050505]"></div>
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
         style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
</div>

<nav class="fixed top-0 w-full z-50 border-b border-black/5 dark:border-white/5 bg-white/70 dark:bg-black/40 backdrop-blur-xl transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <a href="#top" class="flex items-center gap-3 group">
            <div class="w-1.5 h-8 bg-orange-600 rounded-full group-hover:h-6 transition-all duration-300 shadow-[0_0_15px_rgba(234,88,12,0.5)]"></div>
            <div class="flex flex-col">
                <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white leading-none">
                    Pro<span class="text-orange-600 dark:text-orange-500">Шашлык</span>
                </span>
                <span class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-widest mt-1">Краснодар</span>
            </div>
        </a>

        <div class="flex items-center gap-4">
            <div class="hidden sm:block text-right">
                <a href="tel:+79189580002" class="block font-bold text-gray-900 dark:text-white hover:text-orange-600 transition">
                    +7 (918) 958-00-02
                </a>
                <span class="text-xs text-gray-500">09:00 - 22:00</span>
            </div>

            <button id="theme-toggle"
                    type="button"
                    class="p-2 rounded-xl bg-gray-200/50 dark:bg-white/10 text-gray-600 dark:text-gray-200 hover:text-orange-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>
    </div>
</nav>

<section id="top" class="relative z-10 min-h-screen flex flex-col justify-center items-center text-center px-4 pt-20">
    <div class="max-w-4xl w-full">
        <div class="animate-enter inline-flex px-4 py-1.5 rounded-full border border-gray-300 dark:border-white/10 bg-white/60 dark:bg-white/5 backdrop-blur-xl items-center gap-2 mb-8 shadow-xl">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-xs font-bold uppercase tracking-widest opacity-80">Принимаем заказы</span>
        </div>

        <h1 class="animate-enter delay-100 text-5xl sm:text-7xl md:text-8xl font-black leading-[0.95] mb-6 tracking-tighter drop-shadow-2xl">
            МЯСО <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-600">НА УГЛЯХ</span>
        </h1>

        <p class="animate-enter delay-200 text-lg text-gray-600 dark:text-gray-300 mb-10 max-w-xl mx-auto font-medium">
            Настоящий шашлык, сочные люля и гирос. <br>
            Готовим с душой, доставляем горячим.
        </p>

        <div class="animate-enter delay-300 flex justify-center gap-4">
            <a href="#menu" class="px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-black font-bold rounded-full hover:scale-105 transition shadow-lg">
                Перейти к меню
            </a>
        </div>
    </div>
</section>

<section id="menu" class="relative z-10 py-20 px-4 max-w-7xl mx-auto">
    <div class="mb-12 border-b border-gray-200 dark:border-gray-800 pb-6">
        <h2 class="text-3xl md:text-5xl font-black mb-2 text-gray-900 dark:text-white">Наше Меню</h2>
        <p class="text-gray-500">Кликните на блюдо, чтобы выбрать количество</p>
    </div>

    @if($products->count() === 0)
        <div class="bg-white/60 dark:bg-white/5 backdrop-blur border border-gray-200 dark:border-white/10 rounded-3xl p-8 text-center">
            <div class="text-xl font-black mb-2">Меню пока пустое</div>
            <div class="text-gray-500 text-sm">Сейчас в таблице <b>products</b> нет товаров (или они выключены).</div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $item)
                @php
                    $title = $item->title ?? $item->name ?? 'Без названия';
                    $desc  = $item->description ?? '';

                    $img = $item->image_url ?? '/images/placeholder.jpg';
                    if ($img && str_contains($img, 'www.dropbox.com')) {
                        $img = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $img);
                    }
                    if (!$img) $img = '/images/placeholder.jpg';

                    $price = (float)($item->price ?? 0);

                    $type = $item->type ?? 'piece';
                    $unit = $item->unit ?? ($type === 'weight' ? 'г' : 'шт.');

                    $portion = $item->portion_weight ?? null;
                    $tags = [];

                    if ($type === 'weight') $tags[] = '100г';
                    if ($portion) $tags[] = '~' . (int)$portion . 'г';
                    if ($type !== 'weight' && !$portion) $tags[] = $unit;
                @endphp

                <div
                    class="menu-item group relative bg-white dark:bg-[#111] rounded-3xl p-3 sm:p-4 transition-all hover:-translate-y-2 hover:shadow-2xl border border-gray-100 dark:border-white/5 cursor-pointer"
                    data-product-id="{{ $item->id }}"
                >
                    <div class="h-48 sm:h-60 rounded-2xl overflow-hidden mb-4 relative bg-gray-100 dark:bg-gray-800">
                        <img src="{{ $img }}"
                             class="menu-item__img w-full h-full object-cover group-hover:scale-110 transition duration-700"
                             alt="{{ $title }}">

                        <div class="menu-item__tag-row absolute top-3 left-3 flex flex-wrap gap-1">
                            @foreach($tags as $tag)
                                <span class="menu-item__tag bg-black/60 backdrop-blur-md text-white px-2 py-1 rounded-lg text-[10px] font-bold uppercase">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="px-1">
                        <h3 class="menu-item__title text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                            {{ $title }}
                        </h3>

                        <p class="menu-item__descr text-gray-500 dark:text-gray-400 text-xs sm:text-sm mb-4 line-clamp-2 h-10">
                            {{ $desc }}
                        </p>

                        <div class="menu-item__bottom mt-auto">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Цена</span>
                                <span class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">
                                    <span class="menu-item__price"
                                          data-type="{{ $type }}"
                                          data-unit="{{ $unit }}"
                                          @if($portion) data-portion-weight="{{ (int)$portion }}" @endif
                                    >{{ number_format($price, 0, '.', '') }}</span> ₽
                                </span>
                            </div>

                            <button type="button" class="bg-gray-100 dark:bg-white/10 group-hover:bg-orange-600 group-hover:text-white text-gray-900 dark:text-white w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center transition-all duration-300 shadow-sm">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

<section class="relative z-10 py-20 px-4 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-[#111] rounded-3xl p-6 border border-gray-200 dark:border-white/10 shadow-xl flex flex-col justify-between h-full">
            <div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="text-orange-500">📍</span> Зона доставки
                </h3>

                <ul class="space-y-4 text-gray-600 dark:text-gray-300 text-sm mb-6">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold block text-gray-900 dark:text-white">Бесплатная доставка</span>
                            При заказе от 2000 ₽ или если вы находитесь в радиусе 2 км от нас.
                        </div>
                    </li>

                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold block text-gray-900 dark:text-white">Стоимость доставки — 300 ₽</span>
                            Если сумма заказа меньше 2000 ₽.
                        </div>
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl overflow-hidden h-48 relative border border-gray-200 dark:border-white/10">
                <img src="https://static-maps.yandex.ru/1.x/?ll=38.975313,45.035470&z=11&l=map&size=600,300&lang=ru_RU"
                     class="w-full h-full object-cover grayscale opacity-70 hover:grayscale-0 transition duration-500"
                     alt="Карта">
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <span class="bg-white/80 dark:bg-black/80 backdrop-blur px-4 py-2 rounded-lg text-xs font-bold text-gray-900 dark:text-white shadow-lg">
                        Краснодар
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-6 shadow-xl text-white relative overflow-hidden group">
                <h3 class="text-2xl font-black mb-2 relative z-10 uppercase">Только на углях</h3>
                <p class="text-white/90 text-sm relative z-10 leading-relaxed">
                    Настоящий мангал, березовые угли и правильный жар. Вы почувствуете этот дымок в каждом кусочке.
                </p>
                <div class="mt-6 inline-block bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold border border-white/30">
                    🔥 100% Real BBQ
                </div>
            </div>

            <div class="bg-white dark:bg-[#181818] rounded-3xl p-6 border border-gray-200 dark:border-white/10 shadow-xl flex items-center gap-6">
                <div class="w-16 h-16 bg-gray-100 dark:bg-white/5 rounded-full flex items-center justify-center shrink-0 text-3xl">🥩</div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1 uppercase">Свежее мясо</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Фермерское мясо каждое утро. Маринуем сами, без химии.</p>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-white/5 rounded-3xl p-6 border border-gray-200 dark:border-white/5 shadow-inner">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 uppercase">💳 Оплата переводом</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    Принимаем платежи через СБП или по QR-коду. Это быстро, современно и безопасно.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="reviews" class="relative z-10 py-20 px-4 max-w-7xl mx-auto">
    <div class="mb-12">
        <h2 class="text-3xl md:text-5xl font-black mb-2 text-gray-900 dark:text-white uppercase tracking-tighter">О нас говорят</h2>
        <div class="w-20 h-1.5 bg-orange-600 rounded-full"></div>
    </div>

    @php
        $reviews = [
            ['name' => 'Александр', 'text' => 'Лучший люля в городе! Привезли горячим, мясо сочное, соус просто бомба. Теперь заказываем только здесь.', 'stars' => 5],
            ['name' => 'Марина', 'text' => 'Заказывали комбо на компанию. Рёбрышки тают во рту. Доставили за 50 минут, даже быстрее чем обещали.', 'stars' => 5],
            ['name' => 'Дмитрий', 'text' => 'Настоящий запах костра! Скепасти огромная, еле доели вдвоем. Отдельное спасибо за вежливого курьера.', 'stars' => 5],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($reviews as $rev)
            <div class="bg-white dark:bg-[#111] border border-gray-200 dark:border-white/10 p-8 rounded-3xl hover:-translate-y-2 transition-all duration-300 shadow-xl relative overflow-hidden group">
                <div class="flex gap-1 mb-4">
                    @for($i=0; $i<$rev['stars']; $i++)
                        <span class="text-orange-500">★</span>
                    @endfor
                </div>

                <p class="text-gray-600 dark:text-gray-300 italic mb-6 relative z-10">«{{ $rev['text'] }}»</p>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-500 to-red-600 flex items-center justify-center text-white font-bold">
                        {{ mb_substr($rev['name'], 0, 1) }}
                    </div>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $rev['name'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="faq" class="relative z-10 py-20 px-4 max-w-3xl mx-auto">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-5xl font-black mb-4 text-gray-900 dark:text-white uppercase tracking-tighter">Вопросы</h2>
        <p class="text-gray-500">Всё, что вы хотели спросить о нашем мясе</p>
    </div>

    @php
        $faqs = [
            ['q' => 'Как быстро вы доставляете?', 'a' => 'В среднем доставка занимает 60-90 минут. В праздники время может увеличиться, но мы предупредим.'],
            ['q' => 'Какое мясо вы используете?', 'a' => 'Только фермерское мясо из Краснодарского края. Закупаем каждое утро, никакой заморозки.'],
            ['q' => 'Можно ли заказать к определенному времени?', 'a' => 'Да, напишите желаемое время в комментарии к заказу, и мы подстроимся.'],
            ['q' => 'Как происходит оплата?', 'a' => 'После заказа появится QR-код. Мы начинаем готовить сразу после подтверждения перевода.'],
        ];
    @endphp

    <div class="space-y-4">
        @foreach($faqs as $faq)
            <div class="faq-item border border-gray-200 dark:border-white/10 rounded-2xl overflow-hidden bg-white/50 dark:bg-white/5 backdrop-blur-sm">
                <button type="button" class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">
                    <span class="font-bold text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-orange-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                    <div class="px-6 pb-5 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<div id="menuCart" class="fixed right-4 bottom-4 w-[90vw] sm:w-[320px] max-h-[85vh] bg-white/95 dark:bg-[#111]/95 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-2xl shadow-2xl p-4 flex flex-col gap-3 z-[9998] transition-all">
    <div class="flex justify-between items-center border-b border-gray-200 dark:border-white/10 pb-2">
        <span class="font-bold text-gray-900 dark:text-white uppercase tracking-wider text-sm">Ваш заказ</span>

        <div class="flex items-center gap-2">
            <span class="text-sm font-bold text-orange-600"><span id="cartTotal">0.00</span> ₽</span>
            <button id="cartToggleBtn" type="button" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-white/10 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-white/20 transition">—</button>
        </div>
    </div>

    <div id="cartItems" class="flex-1 overflow-y-auto min-h-[50px] max-h-[230px] scrollbar-hide text-sm text-gray-700 dark:text-gray-300">
        <p class="text-gray-400 text-center py-4 italic">Корзина пуста</p>
    </div>

    <div id="cartInputs" class="flex flex-col gap-2">
        <div>
            <input type="text" id="orderAddress"
                   class="w-full bg-gray-50 dark:bg-black/50 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-orange-500 transition"
                   placeholder="Адрес доставки *"/>
            <p id="orderAddressError" class="hidden text-xs text-red-500 mt-1"></p>
        </div>

        <div>
            <input type="tel" id="orderPhone"
                   class="w-full bg-gray-50 dark:bg-black/50 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-orange-500 transition"
                   placeholder="Ваш телефон *"/>
            <p id="orderPhoneError" class="hidden text-xs text-red-500 mt-1"></p>
        </div>

        <textarea id="orderComment"
                  class="w-full bg-gray-50 dark:bg-black/50 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-orange-500 transition resize-none h-16"
                  placeholder="Комментарий к заказу"></textarea>

        <button id="submitOrderBtn" disabled
                class="w-full py-3 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-bold text-sm transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg flex justify-center items-center gap-2">
            <span>Оформить заказ</span>
            <svg id="btnSpinner" class="animate-spin h-5 w-5 text-white hidden" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>
    </div>
</div>

<div id="menuModal" class="fixed inset-0 z-[9999] hidden">
    <div id="menuModalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90vw] max-w-md max-h-[90vh] bg-white dark:bg-[#181818] rounded-3xl shadow-2xl overflow-hidden flex flex-col">
        <button id="menuModalClose" type="button" class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-black/70 transition">&times;</button>

        <div class="h-64 bg-gray-200 dark:bg-gray-800">
            <img id="modalImg" src="" class="w-full h-full object-cover" alt="">
        </div>

        <div class="p-6 flex flex-col gap-4 overflow-y-auto">
            <div>
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-900 dark:text-white mb-2"></h3>
                <p id="modalDescr" class="text-sm text-gray-500 dark:text-gray-400"></p>
                <p class="text-xs text-gray-400 mt-2 italic">Цена: <span id="modalBasePrice" class="text-orange-500 font-bold"></span></p>
            </div>

            <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-4">
                <label class="text-xs text-gray-500 dark:text-gray-400 mb-2 block font-bold uppercase tracking-wider">Количество</label>
                <div class="flex items-center gap-3">
                    <input type="number" id="modalAmount"
                           class="flex-1 bg-white dark:bg-black/50 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-lg font-bold text-center focus:outline-none focus:border-orange-500 transition dark:text-white"
                           inputmode="decimal">
                    <span id="modalUnit" class="text-sm font-bold text-gray-500">шт.</span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">Итого:</span>
                <span class="text-2xl font-black text-gray-900 dark:text-white"><span id="modalTotalPrice">0.00</span> ₽</span>
            </div>

            <button id="modalAddBtn" type="button" class="w-full py-4 bg-orange-600 hover:bg-orange-500 text-white font-bold rounded-xl transition shadow-lg">
                Добавить к заказу
            </button>
        </div>
    </div>
</div>

<div id="successModal" class="fixed inset-0 z-[10000] hidden bg-black/95 backdrop-blur-md flex justify-center items-center px-4">
    <div class="bg-white dark:bg-[#181818] w-full max-w-sm rounded-3xl p-6 text-center shadow-2xl border border-white/10">
        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-1">Заказ создан!</h3>
        <p class="text-orange-500 font-bold text-sm mb-6 uppercase tracking-wider">Ожидание оплаты</p>

        <div class="bg-gray-100 dark:bg-white/5 p-4 rounded-2xl mb-6 border border-dashed border-gray-300 dark:border-gray-700">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">К переводу</p>
            <p class="text-4xl font-black text-gray-900 dark:text-white mb-4"><span id="successTotal">0.00</span> ₽</p>

            <div class="w-48 h-48 mx-auto bg-white p-2 rounded-xl mb-3">
                <img src="/images/qr.jpg" class="w-full h-full object-contain" alt="QR">
            </div>

            <p class="text-[10px] text-gray-500 leading-tight">
                Наведите камеру банка или переведите на:<br>
                <span class="font-bold text-gray-900 dark:text-white text-sm">+7 (918) 958-00-02</span>
            </p>
        </div>

        <button id="confirmPaymentBtn" type="button" onclick="confirmPayment()"
                class="w-full py-4 bg-green-600 hover:bg-green-500 text-white font-bold text-lg rounded-xl transition shadow-lg flex justify-center items-center gap-2">
            ✅ Я оплатил(а)
        </button>

        <button type="button" onclick="location.reload()" class="mt-4 text-gray-500 text-xs underline">Закрыть</button>
    </div>
</div>

<footer class="relative bg-white/30 dark:bg-black/40 backdrop-blur-2xl border-t border-white/50 dark:border-white/10 pt-20 pb-10 px-4 mt-20 rounded-t-[3rem] overflow-hidden shadow-[0_-10px_40px_rgba(0,0,0,0.05)] dark:shadow-[0_-10px_40px_rgba(0,0,0,0.2)]">
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-orange-600/30 blur-[150px] rounded-full pointer-events-none mix-blend-soft-light dark:mix-blend-normal"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
        <div class="flex flex-col items-start gap-6">
            <div class="flex items-center gap-4">
                <div class="p-2 bg-white/20 dark:bg-white/5 backdrop-blur-md border border-white/20 dark:border-white/5 rounded-2xl shadow-lg rotate-3 hover:rotate-0 transition-transform duration-300">
                    <img src="https://sun9-27.userapi.com/s/v1/ig2/11mXNV5obQZsgtmXAAavNPUsilEznokU_r4Hck9XCQph0qvCccgjXbUXXCSqNSs1-O-xnayAOihyVx6YUJkLSr6Y.jpg?quality=95&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1024x1024&from=bu&cs=1024x0"
                         alt="ProШашлык Лого"
                         class="w-20 h-20 rounded-xl object-cover">
                </div>

                <div>
                    <span class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-none block">
                        Pro<span class="text-orange-600 dark:text-orange-500">Шашлык</span>
                    </span>
                    <span class="text-xs text-gray-800 dark:text-gray-300 font-bold tracking-widest uppercase">Краснодар</span>
                </div>
            </div>

            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed max-w-xs font-medium">
                Жарим мясо на настоящих березовых углях. Доставляем горячим по Краснодару. Вкус, за который нам не стыдно.
            </p>
        </div>

        <div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 bg-orange-500 rounded-full"></span> Навигация
            </h4>

            <ul class="space-y-4 text-gray-700 dark:text-gray-300 font-medium">
                <li><a href="#top" class="hover:text-orange-600 dark:hover:text-orange-500 hover:pl-2 transition-all">Главная</a></li>
                <li><a href="#menu" class="hover:text-orange-600 dark:hover:text-orange-500 hover:pl-2 transition-all">Меню</a></li>
                <li><a href="#reviews" class="hover:text-orange-600 dark:hover:text-orange-500 hover:pl-2 transition-all">Отзывы клиентов</a></li>
                <li><a href="#faq" class="hover:text-orange-600 dark:hover:text-orange-500 hover:pl-2 transition-all">Вопросы и ответы</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 bg-orange-500 rounded-full"></span> Контакты
            </h4>

            <div class="flex flex-col gap-4">
                <div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1 font-bold">Телефон доставки:</p>
                    <a href="tel:+79189580002"
                       class="text-3xl font-black text-orange-600 dark:text-orange-500 hover:text-orange-700 transition leading-none">
                        +7 (918) 958-00-02
                    </a>
                </div>

                <p class="text-gray-700 dark:text-gray-300 text-sm flex items-center gap-2 font-medium">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Ежедневно с 09:00 до 22:00
                </p>
            </div>
        </div>
    </div>

    <div class="mt-16 pt-8 border-t border-white/20 dark:border-white/5 text-center text-gray-600 dark:text-gray-400 text-sm relative z-10 font-medium">
        <p class="flex items-center justify-center gap-2">
            <br class="sm:hidden">
            &copy; 2026 ProШашлык.
        </p>
    </div>
</footer>

<a href="{{ url('/admin/login') }}"
   class="fixed left-4 bottom-4 z-[9997] text-xs font-bold uppercase tracking-widest opacity-60 hover:opacity-100 transition">
    Вход для администратора
</a>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const cart = [];
    let currentProduct = null;
    let currentOrderPublicId = null;
    let isCartCollapsed = false;

    const modal = document.getElementById("menuModal");
    const modalAmount = document.getElementById("modalAmount");
    const modalAddBtn = document.getElementById("modalAddBtn");

    const modalCloseBtn = document.getElementById("menuModalClose");
    const modalBackdrop = document.getElementById("menuModalBackdrop");

    const cartItemsEl = document.getElementById("cartItems");
    const cartTotalEl = document.getElementById("cartTotal");
    const cartInputsEl = document.getElementById("cartInputs");
    const cartToggleBtn = document.getElementById("cartToggleBtn");
    const themeToggleBtn = document.getElementById("theme-toggle");

    const orderAddressEl = document.getElementById("orderAddress");
    const orderPhoneEl = document.getElementById("orderPhone");
    const orderCommentEl = document.getElementById("orderComment");

    const orderAddressErrorEl = document.getElementById("orderAddressError");
    const orderPhoneErrorEl = document.getElementById("orderPhoneError");

    const submitOrderBtn = document.getElementById("submitOrderBtn");
    const btnSpinner = document.getElementById("btnSpinner");

    const successModal = document.getElementById("successModal");
    const successTotal = document.getElementById("successTotal");

    function money(v) {
        const n = Number(v || 0);
        return n.toFixed(2);
    }

    function normalizeUnit(type, unit) {
        if (type === "weight") return "г";
        return unit || "шт";
    }

    function getMinByType(type) {
        return type === "weight" ? 100 : 1;
    }

    function getMaxByType(type) {
        return type === "weight" ? 3000 : 20;
    }

    function getStepByType(type) {
        return type === "weight" ? 50 : 1;
    }

    function sanitizeQty(qty, type) {
        let value = Number(qty);

        if (!Number.isFinite(value)) {
            value = getMinByType(type);
        }

        value = Math.max(getMinByType(type), Math.min(getMaxByType(type), value));

        if (type === "weight") {
            const step = getStepByType(type);
            value = Math.round(value / step) * step;
            value = Math.max(getMinByType(type), Math.min(getMaxByType(type), value));
        } else {
            value = Math.max(1, parseInt(value, 10) || 1);
        }

        return value;
    }

    function formatAmount(qty, type, unit) {
        return `${parseInt(qty, 10)} ${normalizeUnit(type, unit)}`;
    }

    function getUnitPriceLabel(price, type) {
        if (type === "weight") {
            return `${parseInt(price, 10)} ₽ / 100г`;
        }

        return `${parseInt(price, 10)} ₽`;
    }

    function calcItemTotal(price, qty, type) {
        if (type === "weight") {
            return Math.round(((Number(price) / 100) * Number(qty)) * 100) / 100;
        }

        return Math.round((Number(price) * Number(qty)) * 100) / 100;
    }

    function closeMenuModal() {
        modal.classList.add("hidden");
        currentProduct = null;
    }

    function setCartCollapsed(collapsed) {
        isCartCollapsed = Boolean(collapsed);

        if (!cartItemsEl || !cartInputsEl || !cartToggleBtn) return;

        cartItemsEl.classList.toggle("hidden", isCartCollapsed);
        cartInputsEl.classList.toggle("hidden", isCartCollapsed);

        cartToggleBtn.textContent = isCartCollapsed ? "+" : "—";
        cartToggleBtn.setAttribute("aria-expanded", String(!isCartCollapsed));
        cartToggleBtn.setAttribute(
            "aria-label",
            isCartCollapsed ? "Развернуть корзину" : "Свернуть корзину"
        );
    }

    function syncThemeToggleState() {
        if (!themeToggleBtn) return;

        const isDark = document.documentElement.classList.contains("dark");

        themeToggleBtn.setAttribute("aria-pressed", String(isDark));
        themeToggleBtn.setAttribute(
            "aria-label",
            isDark ? "Включить светлую тему" : "Включить тёмную тему"
        );
    }

    function toggleFaqItem(item) {
        const content = item.querySelector(".faq-content");
        const icon = item.querySelector(".faq-btn svg");

        if (!content) return;

        const isOpen = content.style.maxHeight && content.style.maxHeight !== "0px";

        if (isOpen) {
            content.style.maxHeight = "0px";
            item.classList.remove("faq-open");

            if (icon) {
                icon.classList.remove("rotate-180");
            }

            return;
        }

        content.style.maxHeight = content.scrollHeight + "px";
        item.classList.add("faq-open");

        if (icon) {
            icon.classList.add("rotate-180");
        }
    }

    if (modalCloseBtn) {
        modalCloseBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            closeMenuModal();
        });
    }

    if (modalBackdrop) {
        modalBackdrop.addEventListener("click", () => {
            closeMenuModal();
        });
    }

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal && !modal.classList.contains("hidden")) {
            closeMenuModal();
        }
    });

    if (cartToggleBtn) {
        cartToggleBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            setCartCollapsed(!isCartCollapsed);
        });

        setCartCollapsed(false);
    }

    if (themeToggleBtn) {
        syncThemeToggleState();

        themeToggleBtn.addEventListener("click", () => {
            const isDark = document.documentElement.classList.toggle("dark");

            try {
                localStorage.theme = isDark ? "dark" : "light";
            } catch (error) {
                console.warn("Unable to save theme:", error);
            }

            syncThemeToggleState();
        });
    }

    const modalWindow = modal ? modal.querySelector(".absolute.top-1\\/2") : null;
    if (modalWindow) {
        modalWindow.addEventListener("click", (e) => e.stopPropagation());
    }

    document.querySelectorAll(".faq-item").forEach((item) => {
        const btn = item.querySelector(".faq-btn");
        const content = item.querySelector(".faq-content");

        if (content) {
            content.style.maxHeight = "0px";
        }

        if (btn) {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                toggleFaqItem(item);
            });
        }
    });

    window.addEventListener("resize", () => {
        document.querySelectorAll(".faq-item.faq-open").forEach((item) => {
            const content = item.querySelector(".faq-content");
            if (content) {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });

    document.querySelectorAll(".menu-item").forEach(item => {
        item.addEventListener("click", () => {
            const productId = parseInt(item.dataset.productId || 0, 10);

            const title = item.querySelector(".menu-item__title").textContent.trim();
            const desc = item.querySelector(".menu-item__descr").textContent.trim();
            const img = item.querySelector(".menu-item__img").src;

            const priceEl = item.querySelector(".menu-item__price");

            const price = parseFloat(priceEl.textContent.trim()) || 0;
            const type = priceEl.dataset.type || "piece";
            const unit = normalizeUnit(type, priceEl.dataset.unit || "шт");

            document.getElementById("modalTitle").textContent = title;
            document.getElementById("modalDescr").textContent = desc;
            document.getElementById("modalImg").src = img;

            if (type === "weight") {
                document.getElementById("modalBasePrice").textContent = money(price) + " ₽ за 100г";
                modalAmount.value = 300;
            } else {
                document.getElementById("modalBasePrice").textContent = money(price) + " ₽";
                modalAmount.value = 1;
            }

            modalAmount.min = getMinByType(type);
            modalAmount.max = getMaxByType(type);
            modalAmount.step = getStepByType(type);

            document.getElementById("modalUnit").textContent = unit;

            currentProduct = {
                productId,
                title,
                price,
                type,
                unit
            };

            updateModalTotal();
            modal.classList.remove("hidden");
        });
    });

    function updateModalTotal() {
        if (!currentProduct) return;

        const qty = sanitizeQty(modalAmount.value, currentProduct.type);
        modalAmount.value = qty;

        const total = calcItemTotal(currentProduct.price, qty, currentProduct.type);

        document.getElementById("modalTotalPrice").textContent = money(total);
        modalAddBtn.disabled = total <= 0;
    }

    modalAmount.addEventListener("input", updateModalTotal);
    modalAmount.addEventListener("blur", updateModalTotal);

    modalAddBtn.addEventListener("click", () => {
        if (!currentProduct) return;

        const qty = sanitizeQty(modalAmount.value, currentProduct.type);

        cart.push({
            product_id: currentProduct.productId,
            title: currentProduct.title,
            type: currentProduct.type,
            unit: currentProduct.unit,
            qty: qty,
            amount: formatAmount(qty, currentProduct.type, currentProduct.unit),
            unitPrice: getUnitPriceLabel(currentProduct.price, currentProduct.type),
            unitPriceValue: currentProduct.price,
            total: calcItemTotal(currentProduct.price, qty, currentProduct.type)
        });

        renderCart();
        closeMenuModal();
    });

    function renderCart() {
        cartItemsEl.innerHTML = "";

        let total = 0;

        if (cart.length === 0) {
            cartItemsEl.innerHTML = '<p class="text-gray-400 text-center py-4 italic">Корзина пуста</p>';
        } else {
            cart.forEach((item, index) => {
                total += Number(item.total || 0);

                const minusLabel = item.type === "weight" ? "-50г" : "-1";
                const plusLabel = item.type === "weight" ? "+50г" : "+1";

                const div = document.createElement("div");
                div.className = "py-2 border-b border-gray-100 dark:border-white/5";

                div.innerHTML = `
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="font-medium text-gray-900 dark:text-white">
                                ${index + 1}. ${item.title}
                            </div>
                            <div class="text-xs opacity-60 mt-1">
                                ${item.amount}
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="font-bold">${money(item.total)} ₽</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <button type="button"
                                data-action="decrease"
                                data-index="${index}"
                                class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-xs">
                            ${minusLabel}
                        </button>

                        <button type="button"
                                data-action="increase"
                                data-index="${index}"
                                class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-xs">
                            ${plusLabel}
                        </button>

                        <button type="button"
                                data-action="remove"
                                data-index="${index}"
                                class="ml-auto px-3 py-1 rounded-lg bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400 hover:opacity-80 text-xs">
                            Удалить
                        </button>
                    </div>
                `;

                cartItemsEl.appendChild(div);
            });
        }

        cartTotalEl.textContent = money(total);
        checkForm();
    }

    cartItemsEl.addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-action]");
        if (!btn) return;

        const index = parseInt(btn.dataset.index, 10);
        const action = btn.dataset.action;
        const item = cart[index];

        if (!item) return;

        const step = getStepByType(item.type);

        if (action === "remove") {
            cart.splice(index, 1);
            renderCart();
            return;
        }

        if (action === "increase") {
            item.qty = sanitizeQty(Number(item.qty) + step, item.type);
        }

        if (action === "decrease") {
            const newQty = Number(item.qty) - step;

            if (newQty < getMinByType(item.type)) {
                cart.splice(index, 1);
                renderCart();
                return;
            }

            item.qty = sanitizeQty(newQty, item.type);
        }

        item.amount = formatAmount(item.qty, item.type, item.unit);
        item.total = calcItemTotal(item.unitPriceValue, item.qty, item.type);

        renderCart();
    });

    function setFieldError(inputEl, errorEl, message) {
        if (!inputEl || !errorEl) return;

        if (message) {
            inputEl.classList.add("border-red-500");
            errorEl.textContent = message;
            errorEl.classList.remove("hidden");
        } else {
            inputEl.classList.remove("border-red-500");
            errorEl.textContent = "";
            errorEl.classList.add("hidden");
        }
    }

    function validateAddress() {
        const value = orderAddressEl.value.trim();

        if (!value) {
            setFieldError(orderAddressEl, orderAddressErrorEl, "Укажите адрес доставки.");
            return false;
        }

        if (value.length < 8) {
            setFieldError(orderAddressEl, orderAddressErrorEl, "Адрес слишком короткий. Укажите улицу и дом.");
            return false;
        }

        setFieldError(orderAddressEl, orderAddressErrorEl, "");
        return true;
    }

    function validatePhone() {
        const raw = orderPhoneEl.value.trim();
        const digits = raw.replace(/\D/g, '');

        if (!raw) {
            setFieldError(orderPhoneEl, orderPhoneErrorEl, "Укажите номер телефона.");
            return false;
        }

        if (!(digits.length === 11 && (digits.startsWith('7') || digits.startsWith('8')))) {
            setFieldError(orderPhoneEl, orderPhoneErrorEl, "Введите корректный номер в формате +7XXXXXXXXXX.");
            return false;
        }

        setFieldError(orderPhoneEl, orderPhoneErrorEl, "");
        return true;
    }

    function checkForm() {
        const valid = cart.length > 0 && validateAddress() && validatePhone();
        submitOrderBtn.disabled = !valid;
    }

    orderAddressEl.addEventListener("input", checkForm);
    orderPhoneEl.addEventListener("input", checkForm);
    orderAddressEl.addEventListener("blur", validateAddress);
    orderPhoneEl.addEventListener("blur", validatePhone);

    submitOrderBtn.addEventListener("click", async () => {
        const addressValid = validateAddress();
        const phoneValid = validatePhone();

        if (cart.length === 0) {
            alert("Корзина пуста.");
            return;
        }

        if (!addressValid || !phoneValid) {
            checkForm();
            return;
        }

        submitOrderBtn.disabled = true;
        btnSpinner.classList.remove("hidden");

        const total = Math.round(cart.reduce((s, i) => s + Number(i.total || 0), 0) * 100) / 100;

        try {
            const response = await fetch('/send-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    cart: cart.map(i => ({
                        product_id: i.product_id,
                        qty: i.qty
                    })),
                    address: orderAddressEl.value.trim(),
                    phone: orderPhoneEl.value.trim(),
                    comment: orderCommentEl.value.trim()
                })
            });

            const json = await response.json().catch(() => null);

            if (response.ok && json?.status === "success") {
                currentOrderPublicId = json.orderPublicId;
                successTotal.textContent = money(total);
                successModal.classList.remove("hidden");
            } else {
                if (json?.errors) {
                    if (json.errors.address) {
                        setFieldError(orderAddressEl, orderAddressErrorEl, json.errors.address[0]);
                    }
                    if (json.errors.phone) {
                        setFieldError(orderPhoneEl, orderPhoneErrorEl, json.errors.phone[0]);
                    }
                }

                alert(json?.message || "Ошибка заказа");
                submitOrderBtn.disabled = false;
            }
        } catch (e) {
            alert("Ошибка сети");
            submitOrderBtn.disabled = false;
        } finally {
            btnSpinner.classList.add("hidden");
            checkForm();
        }
    });

    window.confirmPayment = async function () {
        if (!currentOrderPublicId) {
            alert("Не найден номер заказа. Попробуйте оформить заказ заново.");
            return;
        }

        const btn = document.getElementById("confirmPaymentBtn");
        btn.disabled = true;

        const originalText = btn.textContent;
        btn.textContent = "Отправляем...";

        try {
            const response = await fetch('/confirm-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    orderPublicId: currentOrderPublicId
                })
            });

            const json = await response.json().catch(() => null);

            if (response.ok && json?.status === 'success') {
                btn.textContent = "Принято ✅ Ждём подтверждение";
                setTimeout(() => location.reload(), 2000);
            } else {
                console.error('confirm-payment failed:', json);
                alert(json?.message || "Не удалось отправить подтверждение оплаты.");
                btn.disabled = false;
                btn.textContent = originalText;
            }
        } catch (e) {
            alert("Ошибка сети при подтверждении оплаты.");
            btn.disabled = false;
            btn.textContent = originalText;
        }
    };
});
</script>

</body>
</html>
