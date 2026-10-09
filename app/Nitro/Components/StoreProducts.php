<?php

namespace App\Nitro\Components;

use App\Nitro\Stores\Cart;
use Nitro\Component;

class StoreProducts extends Component
{
    public Cart $cart;

    public array $products = [
        ['name' => 'Notebook', 'price' => 4],
        ['name' => 'Pen', 'price' => 2],
        ['name' => 'Backpack', 'price' => 35],
    ];
}
