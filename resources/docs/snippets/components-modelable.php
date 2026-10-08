<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Attributes\Modelable;
use Nitro\Fusion\Component;

/** A date input of your own, bound by its parent like any input. */
class DatePicker extends Component
{
    #[Modelable]
    public string $value = '';

    public bool $open = false;

    public function pick(string $date): void
    {
        $this->value = $date;     // the parent's property changes with it
        $this->open = false;
    }
}
