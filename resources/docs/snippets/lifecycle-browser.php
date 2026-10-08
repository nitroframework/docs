public string $search = '';

public int $page = 1;

public array $filters = ['status' => 'open', 'owner' => null];

/** Once the component is live in the page. */
public function mounted(): void
{
    $this->js('$refs.search.focus()');
}

/** After the view changes $search (fusion:model, $set): back to the first page. */
public function updatedSearch(string $value): void
{
    $this->page = 1;
}

/** After the view changes a key under $filters: its new value, and which key. */
public function updatedFilters(mixed $value, ?string $key): void
{
    if ($key === 'status') {
        $this->page = 1;
    }
}

/** After the view changes any property: its path ("filters.owner") and its new value. */
public function updated(string $property, mixed $value): void
{
    Fusion::browser()->storage()->put('tickets.filters', $this->filters);
}

/** When the component leaves the page. */
public function destroyed(): void
{
    Fusion::browser()->storage()->forget('tickets.draft');
}
