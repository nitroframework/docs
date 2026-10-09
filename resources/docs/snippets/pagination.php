use Nitro\Concerns\WithPagination;
use Nitro\Concerns\WithSorting;

class Posts extends Component
{
    use WithPagination, WithSorting;

    public array $posts = [];

    public string $search = '';

    #[Computed]
    public function rows(): array
    {
        $found = array_filter($this->posts, fn ($post) => str_contains(strtolower($post['title']), strtolower($this->search)));

        return $this->paginate($this->sorted($found), 12);
    }

    public function updatedSearch(): void   // A new search starts on the first page.
    {
        $this->resetPage();
    }
}
