<?php

namespace App\Listeners;

use App\Events\StockAdjusted;
use Illuminate\Support\Facades\Log;

class AlertLowStock
{
    private const LOW_STOCK_THRESHOLD = 5;

    public function handle(StockAdjusted $event): void
    {
        if ($event->newStock > 0 && $event->newStock <= self::LOW_STOCK_THRESHOLD) {
            Log::channel('alerts')->warning('Low stock alert', [
                'product_id' => $event->productId,
                'product_name' => $event->productName,
                'current_stock' => $event->newStock,
                'threshold' => self::LOW_STOCK_THRESHOLD,
                'reason' => $event->reason,
                'order_id' => $event->orderId,
                'order_detail_id' => $event->orderDetailId,
            ]);
        }
    }
}
