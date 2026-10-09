<?php

namespace App\Nitro\Components;

use Nitro\Component;

class RenderDemo extends Component
{
    public int $count = 0;

    public string $name = 'Ada';

    public array $authors = [
        'Ada', 'Alan', 'Barbara', 'Donald', 'Edsger', 'Frances', 'Grace', 'Hedy', 'Ivan', 'Joan',
        'Ken', 'Linus', 'Margaret', 'Niklaus', 'Radia', 'Shafi', 'Sophie', 'Tim', 'Vint', 'Whitfield',
    ];

    public function increment(): void
    {
        $this->count++;
    }

    public function addAuthor(): void
    {
        $this->authors[] = 'Author '.(count($this->authors) + 1);
    }
}
