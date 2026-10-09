<?php

namespace App\Nitro\Components;

use Nitro\Component;

class FaqItem extends Component
{
    public string $question = '';

    public string $answer = '';

    public bool $open = false;

    public function mount(string $question, string $answer): void
    {
        $this->question = $question;
        $this->answer = $answer;
    }

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }
}
