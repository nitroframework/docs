---
title: What is NitroPHP?
description: Nitro is a full-stack framework for Laravel. You write a component as a PHP class and a view, and Nitro runs it in the browser, with the server one attribute away.
date: 2026-10-16
---

Nitro brings the browser and Laravel together in one component. You write a PHP class and a view, in Blade or in Vue, React, Solid or Svelte, and Nitro compiles the class to JavaScript that runs in the page. When a method needs the database, you mark it `#[Server]`, and it runs on the server instead.

This post shows what that looks like, where each part of a component runs, and what you get from it.

## A first component

Here is a todo list. The class holds the state and the logic:

```php app/Nitro/Components/Todos.php
<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Computed;
use Nitro\Attributes\Server;
use Nitro\Component;

class Todos extends Component
{
    public array $todos = [];

    public string $title = '';

    public function mount(): void
    {
        $this->todos = auth()->user()->todos()->get(['title', 'done'])->toArray();
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
            'todos' => 'array|max:50',
            'todos.*.title' => 'required|string|max:100',
            'todos.*.done' => 'boolean',
        ]);

        auth()->user()->todos()->delete();
        auth()->user()->todos()->createMany($this->todos);
    }
}
```

The view is Blade, with a few `nitro:` attributes:

```blade resources/views/nitro/components/todos.blade.php
<div>
    <form nitro:submit="add">
        <input nitro:model="title" placeholder="What needs doing?">
        <button>Add</button>
    </form>

    <ul>
        @foreach ($todos as $i => $todo)
            <li>
                <label>
                    <input type="checkbox" nitro:click="toggle($i)" @checked($todo['done'])>
                    {{ $todo['title'] }}
                </label>
            </li>
        @endforeach
    </ul>

    <p>{{ $this->remaining }} left</p>
    <button nitro:click="save">Save</button>
</div>
```

You place it in any Blade view with its tag, `<nitro:todos />`, or make it a page of its own with `Route::nitro()`.

## Where each part runs

Every part of a component has one place where it runs:

- `mount()` runs **on the server**, when the component is created. It can query the database, as it does here.
- `add()`, `toggle()` and `remaining()` run **in the browser**. Nitro compiles them to JavaScript, so adding a todo or ticking one off happens in the page at once.
- `save()` is marked `#[Server]`, so it runs **on the server**. The list comes from the browser, so it validates the list with Laravel's rules before it stores it.
- The view renders **on the server** for the first page, so the page appears quickly and search engines can read all of it. After that, the browser updates it.

If you put code in the wrong place, Nitro tells you. A browser method that queries the database fails the build, and the error names the file and the line.

## What you get

**One class for a feature.** The state, the browser logic and the server calls live together. There is no separate API to write for your own pages, and no second app to keep in step with Laravel.

**Laravel stays Laravel.** Routes, middleware, validation rules, Eloquent and auth all work as they do today. In the browser, Nitro has its own versions of helpers such as `Str::`, `route()` and `__()`.

**The view you prefer.** A component's view can be Blade, Vue, React, Solid or Svelte, and a page can mix them. The PHP class stays the same whichever you choose: `#[View(vue: 'todos')]` swaps the view for a Vue one.

**Fast updates.** A change updates only the parts of the page that show it. There is no virtual DOM and no HTML diffing.

**App-like pages.** `nitro:navigate` moves between pages without a full reload and keeps the back button working, and `nitro:prefetch` loads a page before the click. A page can also defer its slower data, so it shows at once and fills in after.

## Who it is for

Nitro is for Laravel developers who want a rich, fast interface without leaving Laravel to build it. If you write Blade today, you can start with Blade and keep it. If your team knows Vue or React, you can use those for the views, and keep the logic in PHP.

It also runs on the same page as Livewire, because its tags, attributes, scripts and endpoints all use the `nitro:` prefix. You can try it on one page of an existing app.

If you use Inertia today, [Coming from Inertia](/docs/coming-from-inertia) maps what you know to Nitro.

## Getting started

Nitro needs PHP 8.3 or higher and Laravel 13. Install it with Composer:

```bash
composer require nitro/nitro
```

Then follow the [Quickstart](/docs/quickstart) to build the todo list above, step by step, or read [How Nitro works](/docs/how-it-works) to see what the compiler does on the first render and on a click.
