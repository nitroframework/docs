#[View('views', engine: 'chart')]
class ViewsChart extends Component
{
    /** @var list<array{label: string, views: int}> */
    #[Locked]
    public array $months = [];

    public function mount(): void
    {
        $this->months = Post::monthlyViews(now()->year);
    }
}
