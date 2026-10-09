<?php

namespace App\Nitro\Stores;

use Nitro\Attributes\Computed;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Attributes\Validate;
use Nitro\Store;

class Cart extends Store
{
    #[Validate(['items' => 'array|max:20', 'items.*.name' => 'required|string|max:40', 'items.*.price' => 'required|integer|min:0'])]
    public array $items = [];

    #[Locked]
    public string $savedAt = '';

    public function mount(): void
    {
        $this->items = session('store-cart.items', []);
        $this->savedAt = session('store-cart.saved_at', '');
    }

    public function add(array $product): void
    {
        $this->items[] = ['name' => $product['name'], 'price' => $product['price']];
    }

    public function remove(int $index): void
    {
        array_splice($this->items, $index, 1);
    }

    #[Computed]
    public function count(): int
    {
        return count($this->items);
    }

    #[Computed]
    public function total(): int
    {
        return array_sum(array_column($this->items, 'price'));
    }

    #[Server]
    public function save(): void
    {
        $this->savedAt = now()->format('H:i:s');

        // This demo keeps the cart in the session. Your app would save it to the database.
        session(['store-cart.items' => $this->items, 'store-cart.saved_at' => $this->savedAt]);
    }
}
