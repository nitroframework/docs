<?php

namespace App\Nitro\Components;

use App\Support\BankFeed;
use Illuminate\Contracts\View\View;
use Nitro\Attributes\Locked;
use Nitro\Component;
use Throwable;

class BankBalance extends Component
{
    #[Locked]
    public int $balanceCents = 0;

    /** The bank's API: when it is down, this throws. */
    public function mount(BankFeed $feed): void
    {
        $this->balanceCents = $feed->today()['balance_cents'];
    }

    /** Shown in the component's place when it fails. */
    public function fallback(Throwable $exception): View
    {
        return view('partials.bank-unavailable');
    }
}
