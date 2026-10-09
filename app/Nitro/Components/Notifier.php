<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Server;
use Nitro\Component;

class Notifier extends Component
{
    #[Server]
    public function save(): void
    {
        // A demo: nothing is saved. A real method would write to the database first.
        $this->dispatch('notify', 'Saved on the server at '.now()->format('H:i:s'), 'success');
    }
}
