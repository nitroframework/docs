use Nitro\Attributes\Cached;
use Nitro\Attributes\Computed;
use Nitro\Attributes\Html;
use Nitro\Attributes\On;
use Nitro\Attributes\Server;

class Invoice extends Component
{
    #[Computed]                             // worked out in the browser, read as $this->total
    public function total(): float
    {
        return array_sum(array_column($this->lines, 'amount'));
    }

    #[Html]                                 // made on the server, placed by the view: {!! $this->terms !!}
    public function terms(): string
    {
        return Str::markdown($this->termsMarkdown, ['html_input' => 'escape']);
    }

    #[Server]                               // runs on the server, called from the browser
    #[Cached(seconds: 300, tags: ['rates'])] // its result kept for five minutes
    public function exchangeRate(string $currency): float
    {
        return Rates::latest($currency);
    }

    #[On('customer-changed')]               // runs when the event is dispatched
    public function refresh(): void
    {
        // ...
    }
}
