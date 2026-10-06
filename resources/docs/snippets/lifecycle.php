public function mount(Team $team): void   // server: once, when the component is created
{
    $this->members = $team->members()->pluck('name')->all();
}

public function updatedSearch(string $value): void   // browser: after fusion:model changes $search
{
    $this->page = 1;
}

public function mounted(): void   // browser: once the component is live
{
    $this->js('$refs.search.focus()');
}
