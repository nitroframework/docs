<?php

namespace App\Nitro\Components;

use Nitro\Component;

/** No mount(): the tag's values set these properties, and follow the parent when they change. */
class OrderLine extends Component
{
    public string $label = '';

    public int $quantity = 1;

    public int $unitPrice = 0;

    public bool $editable = true;

    public function total(): int
    {
        return $this->quantity * $this->unitPrice;
    }
}
