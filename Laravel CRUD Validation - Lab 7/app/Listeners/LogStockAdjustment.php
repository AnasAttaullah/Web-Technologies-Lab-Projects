<?php

namespace App\Listeners;

use App\Events\StockAdjusted;
use Illuminate\Support\Facades\Log;

class LogStockAdjustment
{
    public function handle(StockAdjusted $event): void
    {
        Log::channel('stock')->info('Stock adjusted', [
            'product_id' => $event->productId,
            'product_name' => $event->productName,
            'previous_stock' => $event->previousStock,
            'new_stock' => $event->newStock,
            'change' => $event->newStock - $event->previousStock,
            'reason' => $event->reason,
            'order_id' => $event->orderId,
            'order_detail_id' => $event->orderDetailId,
        ]);
    }
}
