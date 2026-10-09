<?php

namespace App\Nitro\Components;

use App\Models\Team;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Component;

class TeamMembers extends Component
{
    #[Locked]
    public int $teamId;

    public array $members = [];

    /** Every request, first: on creation and on each #[Server] call, before anything else runs. */
    public function boot(): void
    {
        abort_unless(auth()->check(), 401);
    }

    /** Once, when the component is created: its starting state. */
    public function mount(Team $team): void
    {
        $this->teamId = $team->id;
        $this->members = $team->members()->orderBy('name')->pluck('name')->all();
    }

    /** Each #[Server] call, once the state is restored, before the browser's changes are applied. */
    public function hydrate(): void
    {
        logger()->debug('team members call', ['team' => $this->teamId]);
    }

    /** Every request, last, before the state goes to the browser. */
    public function dehydrate(): void
    {
        $this->members = array_values(array_unique($this->members));
    }

    #[Server]
    public function remove(string $name): void
    {
        Team::findOrFail($this->teamId)->members()->where('name', $name)->delete();
        $this->members = array_values(array_diff($this->members, [$name]));
    }
}
