public ?array $stats = null;

public function mount(): void
{
    $this->defer('stats', fn () => Order::stats());
}
