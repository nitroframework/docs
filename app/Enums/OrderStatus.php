<?php

namespace App\Enums;

use Nitro\Attributes\Browser;

#[Browser]
enum OrderStatus: string
{
    case Placed = 'placed';
    case Packed = 'packed';
    case Shipped = 'shipped';
    case Delivered = 'delivered';

    public function label(): string
    {
        return match ($this) {
            self::Placed => 'Placed',
            self::Packed => 'Packed',
            self::Shipped => 'On its way',
            self::Delivered => 'Delivered',
        };
    }

    public function next(): self
    {
        return match ($this) {
            self::Placed => self::Packed,
            self::Packed => self::Shipped,
            default => self::Delivered,
        };
    }

    public function isFinal(): bool
    {
        return $this === self::Delivered;
    }
}
