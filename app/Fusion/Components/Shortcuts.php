<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Component;

class Shortcuts extends Component
{
    public string $draft = '';

    public array $notes = [];

    public bool $menu = false;

    public int $seconds = 0;

    public function add(): void
    {
        if (trim($this->draft) !== '') {
            array_unshift($this->notes, trim($this->draft));
            $this->draft = '';
        }
    }

    public function tick(): void
    {
        $this->seconds++;
    }
}
