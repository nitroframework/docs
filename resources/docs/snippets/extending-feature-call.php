namespace App\Nitro\Features;

use Closure;
use Illuminate\Support\Facades\DB;
use Nitro\Component;
use Nitro\Feature;

class InTransaction extends Feature
{
    /** Every #[Server] method in a database transaction: if it throws, what it wrote is rolled back. */
    public function call(Component $component, string $method, array $arguments, Closure $run): mixed
    {
        return DB::transaction($run);
    }
}
