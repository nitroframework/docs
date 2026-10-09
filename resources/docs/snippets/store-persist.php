use Nitro\Attributes\Locked;
use Nitro\Attributes\Persist;
use Nitro\Attributes\Sync;
use Nitro\Store;

#[Persist]                          // Keep the store's values in localStorage.
class Cart extends Store
{
    #[Sync]                         // Share this property with the site's other open tabs.
    public array $items = [];

    #[Locked]                       // The server sets this one, so it is never kept or shared.
    public string $savedAt = '';
}
