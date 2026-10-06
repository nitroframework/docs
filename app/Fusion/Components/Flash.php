<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Attributes\Server;
use Nitro\Fusion\Component;
use Nitro\Fusion\Facades\Fusion;

class Flash extends Component
{
    #[Server]
    public function save(): void
    {
        Fusion::flash('toast', 'Saved on the server at '.now()->format('H:i:s'));
    }
}
