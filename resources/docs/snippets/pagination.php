use Nitro\Concerns\WithPagination;
use Nitro\Concerns\WithSorting;

class Students extends Component
{
    use WithPagination, WithSorting;

    public array $students = [];

    public string $search = '';

    #[Computed]
    public function rows(): array
    {
        $found = array_filter($this->students, fn ($student) => str_contains(strtolower($student['name']), strtolower($this->search)));

        return $this->paginate($this->sorted($found), 12);
    }

    public function updatedSearch(): void   // A new search starts on the first page.
    {
        $this->resetPage();
    }
}
