<?php

namespace App\Nitro\Components\Blog;

use Nitro\Attributes\Locked;
use Nitro\Component;

/**
 * One blog, five frameworks on one page: a Svelte form, a Vue list, React activity, Solid stats
 * and a Blade card that hears Reverb. None of them knows the others; they talk through events.
 */
class Together extends Component
{
    /** Whether Reverb is set up here: the live card needs it. */
    #[Locked]
    public bool $live = false;

    public function mount(): void
    {
        $this->live = config('broadcasting.default') === 'reverb';
    }
}
