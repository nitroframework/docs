<?php

namespace App\Nitro\Components;

use Nitro\Component;

class RenderDemo extends Component
{
    public int $count = 0;

    public string $name = 'Ada';

    public array $students = [
        'Ada', 'Alan', 'Barbara', 'Donald', 'Edsger', 'Frances', 'Grace', 'Hedy', 'Ivan', 'Joan',
        'Ken', 'Linus', 'Margaret', 'Niklaus', 'Radia', 'Shafi', 'Sophie', 'Tim', 'Vint', 'Whitfield',
    ];

    public function increment(): void
    {
        $this->count++;
    }

    public function enrol(): void
    {
        $this->students[] = 'Student '.(count($this->students) + 1);
    }
}
