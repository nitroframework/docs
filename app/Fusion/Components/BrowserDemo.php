<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Component;
use Nitro\Fusion\Facades\Fusion;

class BrowserDemo extends Component
{
    public string $note = '';

    public bool $copied = false;

    public array $values = [3, 7, 5, 9];

    /** Runs in the browser once the component is live. It reads the note saved last time, and draws the chart. */
    public function mounted(): void
    {
        $this->note = Fusion::browser()->storage()->get('docs-note', '');
        $this->draw();
    }

    public function updated(string $property): void
    {
        if ($property === 'note') {
            Fusion::browser()->storage()->set('docs-note', $this->note);
            $this->copied = false;
        }

        if (str_starts_with($property, 'values')) {
            $this->draw();
        }
    }

    public function copy(): void
    {
        Fusion::browser()->clipboard()->write($this->note, fn () => $this->copied = true);
    }

    public function draw(): void
    {
        $canvas = Fusion::browser()->canvas('chart')->size(260, 110)->clear()->fillStyle('#8b5cf6');

        foreach ($this->values as $i => $value) {
            $canvas->fillRect(12 + $i * 62, 108 - $value * 10, 46, $value * 10);
        }
    }
}
