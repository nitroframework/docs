class PostSearch extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    public array $posts = [];

    public function mount(): void
    {
        $this->posts = Post::latest()->get()->toArray();
    }

    #[Computed]
    public function found(): array
    {
        return array_filter($this->posts, fn ($post) => stripos($post['title'], $this->search) !== false);
    }
}
