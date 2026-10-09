<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Computed;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Component;

class Todos extends Component
{
    public array $todos = [];

    public string $title = '';

    #[Locked]
    public string $savedAt = '';

    public function mount(): void
    {
        $this->todos = session('todos.list', []);
        $this->savedAt = session('todos.saved_at', '');
    }

    public function add(): void
    {
        if (trim($this->title) === '') {
            return;
        }

        $this->todos[] = ['title' => trim($this->title), 'done' => false];
        $this->title = '';
    }

    public function toggle(int $index): void
    {
        $this->todos[$index]['done'] = ! $this->todos[$index]['done'];
    }

    #[Computed]
    public function remaining(): int
    {
        return count(array_filter($this->todos, fn ($todo) => ! $todo['done']));
    }

    #[Server]
    public function save(): void
    {
        $this->validate([
            'todos' => 'array|max:20',
            'todos.*.title' => 'required|string|max:100',
            'todos.*.done' => 'boolean',
        ]);

        $this->savedAt = now()->format('H:i:s');

        // This demo keeps the list in the session. Your app would save it to the database.
        session(['todos.list' => $this->todos, 'todos.saved_at' => $this->savedAt]);
    }
}
