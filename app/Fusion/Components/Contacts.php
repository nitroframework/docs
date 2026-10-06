<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Attributes\Computed;
use Nitro\Fusion\Component;

class Contacts extends Component
{
    public string $search = '';

    public array $contacts = [
        ['name' => 'ada lovelace', 'role' => 'mathematician', 'phone' => '020 7946 0018'],
        ['name' => 'grace hopper', 'role' => 'rear admiral', 'phone' => '020 7946 0342'],
        ['name' => 'alan turing', 'role' => 'computer scientist', 'phone' => '020 7946 0571'],
        ['name' => 'katherine johnson', 'role' => 'space scientist', 'phone' => '020 7946 0923'],
    ];

    #[Computed]
    public function found(): array
    {
        $search = strtolower(trim($this->search));

        return array_values(array_filter($this->contacts, fn ($contact) => $search === '' || str_contains($contact['name'], $search)));
    }
}
