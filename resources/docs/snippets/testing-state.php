$orders = $this->get('/orders')->fusionState('orders');

$this->assertCount(12, $orders);
