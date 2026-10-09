use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;

class Checkout extends Component
{
    #[Locked]
    public int $orderId;

    #[Server]
    public function pay(): void
    {
        // The browser can't change $orderId, so this is the order the page was given.
        // Whether it is still unpaid comes from the database, not from the state.
        $order = auth()->user()->orders()->unpaid()->findOrFail($this->orderId);

        $order->pay();
    }
}
