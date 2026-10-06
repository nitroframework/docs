#[On('echo:orders,OrderPlaced')]                         // A public channel.
public function orderPlaced(array $event): void { $this->orders[] = $event['order']; }

#[On('echo-private:orders.{order.id},OrderShipped')]     // A private channel. {order.id} reads the state.
#[Server]
public function orderShipped(array $event): void { $this->order = Order::find($this->order['id'])->toArray(); }

#[On('echo-presence:chat,here')]                          // A presence channel: here, joining, leaving.
public function here(array $users): void { $this->online = $users; }

#[On('echo-notification:App.Models.User.{userId}')]       // Notifications.
public function notified(array $notification): void { $this->unread++; }
