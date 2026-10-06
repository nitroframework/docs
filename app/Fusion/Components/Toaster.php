<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Attributes\On;
use Nitro\Fusion\Component;

class Toaster extends Component
{
    public array $toasts = [];

    public int $next = 1;

    /** Runs when any component dispatches notify, for example with $this->dispatch('notify', 'Saved'). */
    #[On('notify')]
    public function notify(string $message, string $tone = 'info'): void
    {
        $this->toasts[] = ['id' => $this->next++, 'message' => $message, 'tone' => $tone];
        $this->toasts = array_slice($this->toasts, -3);
    }

    public function dismiss(int $id): void
    {
        $this->toasts = array_values(array_filter($this->toasts, fn ($toast) => $toast['id'] !== $id));
    }
}
