<?php

namespace App\Nitro\Components;

use Nitro\Attributes\On;
use Nitro\Component;

/** Without a store, the badge keeps its own copy of the count and the total, and events keep it up to date. */
class ShopBadge extends Component
{
    public int $count = 0;

    public int $total = 0;

    #[On('cart-added')]
    public function added(array $product): void
    {
        $this->count++;
        $this->total += $product['price'];
    }

    #[On('cart-removed')]
    public function removed(array $product): void
    {
        $this->count--;
        $this->total -= $product['price'];
    }
}
