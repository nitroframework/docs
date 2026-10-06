#[Server]
public function add(string $item): void
{
    Order::create(['item' => $item]);
    $this->reload('orders', 'total');
}

public function mount(): void
{
    if ($this->wants('orders')) {
        $this->orders = Order::latest()->get()->toArray();
    }

    if ($this->wants('total')) {
        $this->total = Order::sum('amount');
    }
}
