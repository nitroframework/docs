<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Component;

/** Without a store, the product list holds none of the cart. It dispatches an event for each product added. */
class ShopProducts extends Component
{
    public array $products = [
        ['id' => 1, 'name' => 'Notebook', 'price' => 4],
        ['id' => 2, 'name' => 'Pen', 'price' => 2],
        ['id' => 3, 'name' => 'Backpack', 'price' => 35],
    ];

    public function add(int $index): void
    {
        $this->dispatch('cart-added', $this->products[$index]);
    }
}
