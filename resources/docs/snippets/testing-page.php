use Nitro\Testing\AssertableNitro;

public function test_the_orders_page(): void
{
    $this->get('/orders')->assertOk()->assertNitro(fn (AssertableNitro $page) => $page
        ->page('pages::orders.index')
        ->has('orders', 12)
        ->where('orders.0.status', 'new')
        ->where('total', fn ($total) => $total > 0)
        ->missing('secret')
        ->deferred('stats'));
}
