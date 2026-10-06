use App\Fusion\Components\Cart;

public function test_delivery_is_free_from_30(): void
{
    $cart = new Cart;

    $cart->add(0);    // Notebook, 4
    $this->assertSame(5, $cart->delivery());

    $cart->add(2);    // Backpack, 35
    $this->assertSame(0, $cart->delivery());
}

public function test_the_postcode_is_tidied(): void
{
    $cart = new Cart;

    $cart->updatedPostcode('  sw1a   1aa ');

    $this->assertSame('SW1A 1AA', $cart->postcode);
}
