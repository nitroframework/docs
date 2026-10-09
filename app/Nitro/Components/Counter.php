<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Attributes\Validate;
use Nitro\Component;

class Counter extends Component
{
    #[Validate('integer|min:0|max:1000')]
    public int $count = 0;

    #[Locked]
    public string $savedAt = '';

    public function mount(): void
    {
        $this->count = session('counter.count', 0);
        $this->savedAt = session('counter.saved_at', '');
    }

    public function increment(): void
    {
        $this->count++;
    }

    #[Server]
    public function save(): void
    {
        $this->savedAt = now()->format('H:i:s');

        // This demo keeps the count in the session. Your app would save it to the database.
        session(['counter.count' => $this->count, 'counter.saved_at' => $this->savedAt]);
    }
}
