#[Server]
public function checkout(Payments $payments): void
{
    $this->validate(['items' => 'required|array|min:1']);

    $payments->charge($this->items);

    $this->redirect(route('orders.index'));
}
