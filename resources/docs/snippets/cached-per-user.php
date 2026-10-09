#[Cached(600, tags: ['invoices'], perUser: true)]
public function mount(): void
{
    $this->outstanding = auth()->user()->invoices()->unpaid()->sum('total');
}
