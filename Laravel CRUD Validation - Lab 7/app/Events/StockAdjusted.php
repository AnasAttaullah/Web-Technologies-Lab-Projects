<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockAdjusted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $productId,
        public string $productName,
        public int $previousStock,
        public int $newStock,
        public string $reason,
        public ?int $orderId = null,
        public ?int $orderDetailId = null,
    ) {
    }
}
