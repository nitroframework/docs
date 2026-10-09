$orders = $this->get('/orders')->nitroState('orders');

$this->assertCount(12, $orders);
