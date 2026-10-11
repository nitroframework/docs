use Nitro\Attributes\Persist;
use Nitro\Attributes\Sync;
use Nitro\Store;

#[Persist]                                  // kept in localStorage: a reload keeps the cart
#[Sync]                                     // and every tab of the site shows the same one
class Cart extends Store
{
    public array $items = [];
}
