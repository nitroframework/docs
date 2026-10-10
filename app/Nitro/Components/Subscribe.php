<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Attributes\Validate;
use Nitro\Component;

class Subscribe extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Locked]
    public string $thanks = '';

    #[Server]
    public function subscribe(): void
    {
        $this->validate();

        // A demo: kept in the session, a moment slower so the loading state shows. Your app would save the subscriber.
        usleep(600_000);
        session()->push('docs-subscribers', $this->email);

        $this->thanks = "Thanks! {$this->email} is on the list.";
        $this->reset('email');
    }
}
