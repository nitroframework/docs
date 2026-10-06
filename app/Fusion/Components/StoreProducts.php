<?php

namespace App\Fusion\Components;

use App\Fusion\Stores\Cart;
use Nitro\Fusion\Component;

class StoreProducts extends Component
{
    public Cart $cart;

    public array $products = [
        ['name' => 'Notebook', 'price' => 4],
        ['name' => 'Pen', 'price' => 2],
        ['name' => 'Backpack', 'price' => 35],
    ];
}
