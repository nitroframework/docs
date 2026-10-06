namespace App\Fusion\Attributes;

use Attribute;
use Illuminate\Support\Facades\RateLimiter;
use Nitro\Fusion\Component;
use Nitro\Fusion\FeatureAttribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Throttle extends FeatureAttribute
{
    public function __construct(public int $perMinute = 10) {}

    public function calling(Component $component, string $method, array $arguments): void
    {
        $key = 'fusion:'.$component::class.':'.$method.':'.request()->ip();

        abort_if(RateLimiter::tooManyAttempts($key, $this->perMinute), 429);

        RateLimiter::hit($key);
    }
}
