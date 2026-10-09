<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Server;
use Nitro\Component;
use Nitro\Facades\Nitro;

class Flash extends Component
{
    #[Server]
    public function save(): void
    {
        Nitro::flash('toast', 'Saved on the server at '.now()->format('H:i:s'));
    }
}
