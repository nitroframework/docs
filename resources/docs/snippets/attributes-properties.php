use Nitro\Attributes\Locked;
use Nitro\Attributes\Modelable;
use Nitro\Attributes\Remember;
use Nitro\Attributes\Uploads;
use Nitro\Attributes\Url;
use Nitro\Attributes\Validate;

class Checkout extends Component
{
    #[Locked]                               // the browser reads it, only the server changes it
    public int $orderId;

    #[Validate('required|email')]           // checked on the server whenever the browser changes it
    public string $email = '';

    #[Url(as: 'step')]                      // ?step=2, kept in the address
    public int $page = 1;

    #[Remember]                             // back, forward and a reload bring it back
    public string $note = '';

    #[Modelable]                            // the property a parent's nitro:model binds
    public string $coupon = '';

    #[Uploads]                              // takes several files from <input type="file" multiple>
    public array $receipts = [];
}
