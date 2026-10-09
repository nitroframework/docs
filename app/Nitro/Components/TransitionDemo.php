<?php

namespace App\Nitro\Components;

use Nitro\Component;

class TransitionDemo extends Component
{
    public array $people = ['Ada', 'Grace', 'Alan'];

    public array $waiting = ['Katherine', 'Margaret', 'Edsger', 'Barbara', 'Donald'];

    public bool $open = false;

    public string $tab = 'list';

    public function add(): void
    {
        if ($this->waiting !== []) {
            $this->people[] = array_shift($this->waiting);
        }
    }

    public function remove(string $name): void
    {
        $this->people = array_values(array_filter($this->people, fn ($person) => $person !== $name));
        $this->waiting[] = $name;
    }

    public function shuffle(): void
    {
        shuffle($this->people);
    }
}
