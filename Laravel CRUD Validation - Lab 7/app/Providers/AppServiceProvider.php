<?php

namespace App\Providers;

use App\Events\StockAdjusted;
use App\Listeners\AlertLowStock;
use App\Listeners\LogStockAdjustment;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(StockAdjusted::class, LogStockAdjustment::class);
        Event::listen(StockAdjusted::class, AlertLowStock::class);
    }
}
