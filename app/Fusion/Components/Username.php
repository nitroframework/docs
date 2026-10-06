<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Attributes\Server;
use Nitro\Fusion\Component;

class Username extends Component
{
    public string $name = '';

    public string $result = '';

    #[Server]
    public function check(): void
    {
        $this->validate(['name' => 'required|alpha_dash|min:3|max:20']);

        $this->result = in_array(strtolower($this->name), $this->taken(), true)
            ? "{$this->name} is taken"
            : "{$this->name} is free (checked on PHP ".PHP_VERSION.')';
    }

    /** Only check() calls this method, so it is never sent to the browser. */
    private function taken(): array
    {
        // This demo uses a fixed list. Your app would query the users table.
        return ['admin', 'taylor', 'fusion'];
    }
}
