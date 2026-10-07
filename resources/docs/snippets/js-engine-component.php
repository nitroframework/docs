#[View('revenue', engine: 'chart')]
class RevenueChart extends Component
{
    /** @var list<array{label: string, cents: int}> */
    #[Locked]
    public array $months = [];

    public function mount(): void
    {
        $this->months = Invoice::monthlyRevenue(now()->year);
    }
}
