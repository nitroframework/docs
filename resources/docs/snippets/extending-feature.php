namespace App\Fusion\Features;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Nitro\Fusion\Component;
use Nitro\Fusion\Feature;

class AuditCalls extends Feature
{
    public function __construct(private readonly Request $request) {}

    public function called(Component $component, string $method, mixed $result): void
    {
        Log::info('Fusion call', [
            'component' => $component::class,
            'method' => $method,
            'user' => $this->request->user()?->id,
        ]);
    }
}
