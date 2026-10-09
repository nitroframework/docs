<?php

namespace App\Nitro\Components;

use App\Enums\OrderStatus;
use Nitro\Attributes\Computed;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Component;

class OrderTracker extends Component
{
    /** The order's lines, with prices in pence. The server sets them, so the browser can't change them. */
    #[Locked]
    public array $lines = [
        ['name' => 'Notebook', 'price' => 450, 'quantity' => 2],
        ['name' => 'Fountain pen', 'price' => 2499, 'quantity' => 1],
    ];

    public OrderStatus $status = OrderStatus::Placed;

    #[Locked]
    public string $savedAt = '';

    public function mount(): void
    {
        $this->status = OrderStatus::from(session('order-tracker.status', 'placed'));
        $this->savedAt = session('order-tracker.saved_at', '');
    }

    #[Computed]
    public function total(): int
    {
        return array_sum(array_map(fn (array $line) => $line['price'] * $line['quantity'], $this->lines));
    }

    public function advance(): void
    {
        $this->status = $this->status->next();
    }

    #[Server]
    public function save(): void
    {
        $this->savedAt = now()->format('H:i:s');

        // A demo: kept in the session. Your app would save to the database.
        session(['order-tracker.status' => $this->status->value, 'order-tracker.saved_at' => $this->savedAt]);
    }
}
