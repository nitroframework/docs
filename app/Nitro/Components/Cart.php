<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Computed;
use Nitro\Component;

class Cart extends Component
{
    public array $products = [
        ['name' => 'Notebook', 'price' => 4],
        ['name' => 'Pen', 'price' => 2],
        ['name' => 'Backpack', 'price' => 35],
    ];

    public array $items = [];

    public string $postcode = '';

    public function add(int $index): void
    {
        $this->items[] = $this->products[$index];
    }

    public function remove(int $index): void
    {
        array_splice($this->items, $index, 1);
    }

    public function updatedPostcode(string $value): void
    {
        $this->postcode = strtoupper(preg_replace('/\s+/', ' ', trim($value)));
    }

    #[Computed]
    public function subtotal(): int
    {
        return array_sum(array_column($this->items, 'price'));
    }

    #[Computed]
    public function delivery(): int
    {
        return $this->subtotal === 0 || $this->subtotal >= 30 ? 0 : 5;
    }
}
