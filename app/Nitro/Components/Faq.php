<?php

namespace App\Nitro\Components;

use Nitro\Component;

class Faq extends Component
{
    public array $questions = [];

    public function mount(): void
    {
        $this->questions = [
            ['question' => 'Where do methods run?', 'answer' => 'In the browser. Only the ones marked #[Server] run on the server.'],
            ['question' => 'Is the first page rendered by the server?', 'answer' => 'Yes, with Blade, so it arrives complete. The browser takes over from there.'],
            ['question' => 'Do I write JavaScript?', 'answer' => 'No. Nitro compiles the class and the view to JavaScript for you.'],
        ];
    }
}
