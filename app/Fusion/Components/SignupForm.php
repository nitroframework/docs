<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Attributes\Computed;
use Nitro\Fusion\Attributes\Locked;
use Nitro\Fusion\Attributes\Server;
use Nitro\Fusion\Attributes\Validate;
use Nitro\Fusion\Component;

class SignupForm extends Component
{
    #[Validate('required|string|min:2|max:60', as: 'name')]
    public string $name = '';

    #[Validate('required|email|max:120', as: 'email')]
    public string $email = '';

    #[Validate('required|in:starter,team', as: 'plan')]
    public string $plan = 'starter';

    #[Validate('accepted', as: 'terms')]
    public bool $terms = false;

    #[Locked]
    public string $welcome = '';

    /** Runs in the browser, so the hint follows your typing before anything is sent. */
    #[Computed]
    public function emailLooksRight(): bool
    {
        return $this->email === '' || preg_match('/^[^@\s]+@[^@\s]+\.[^@\s]+$/', $this->email) === 1;
    }

    #[Server]
    public function submit(): void
    {
        $this->validate();

        // A demo: kept in the session. Your app would create the account.
        session()->push('docs-signups', $this->email);

        $this->welcome = "Welcome, {$this->name}: you are on the {$this->plan} plan.";
        $this->reset('name', 'email', 'terms');
    }
}
