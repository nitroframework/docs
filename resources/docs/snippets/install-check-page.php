<?php

namespace App\Nitro\Pages;

use Nitro\Attributes\Title;
use Nitro\Component;

#[Title('Hello')]
class Hello extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }
}
