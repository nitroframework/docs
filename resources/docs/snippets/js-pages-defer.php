public ?int $orders = null;

public function mount(): void
{
    $this->defer('orders', fn () => Order::count());
}
