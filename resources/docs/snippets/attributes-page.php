use Nitro\Attributes\Description;
use Nitro\Attributes\Layout;
use Nitro\Attributes\Navigate;
use Nitro\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Orders')]
#[Description('Every order, newest first, with its status and total.')]
#[Navigate('markup')]                       // shown at once on a visit, its data after
class Index extends Component
{
    // ...
}
