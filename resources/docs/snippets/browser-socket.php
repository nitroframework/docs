public function connect(): void
{
    Nitro::browser()->socket('/ws/orders')
        ->onMessage(fn (array $order) => $this->orders[] = $order)
        ->send(['subscribe' => 'orders']);
}
