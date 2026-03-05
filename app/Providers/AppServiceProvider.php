<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::body.end',
            function () {
                // ✅ Никогда не ломаем админку, даже если файла нет
                if (! View::exists('filament.new-order-sound')) {
                    return '';
                }

                return view('filament.new-order-sound');
            }
        );
    }
}
