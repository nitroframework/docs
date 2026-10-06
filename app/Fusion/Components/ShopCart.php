<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Attributes\On;
use Nitro\Fusion\Component;

/** Without a store, the cart keeps its own copy of the items, and it must dispatch an event for each removal. */
class ShopCart extends Component
{
    public array $items = [];

    #[On('cart-added')]
    public function added(array $product): void
    {
        $this->items[] = $product;
    }

    public function remove(int $index): void
    {
        $product = $this->items[$index];
        array_splice($this->items, $index, 1);
        $this->dispatch('cart-removed', $product);
    }
}
