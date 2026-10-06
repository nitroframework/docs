use Nitro\Fusion\Attributes\Locked;
use Nitro\Fusion\Attributes\Persist;
use Nitro\Fusion\Attributes\Sync;
use Nitro\Fusion\Store;

#[Persist]                          // Keep the store's values in localStorage.
class Cart extends Store
{
    #[Sync]                         // Share this property with the site's other open tabs.
    public array $items = [];

    #[Locked]                       // The server sets this one, so it is never kept or shared.
    public string $savedAt = '';
}
