// modules/Billing/BillingServiceProvider.php
namespace Billing;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        config()->set('nitro.namespaces.billing', [
            'components' => [
                'namespace' => 'Billing\Ui\Components',
                'path' => __DIR__.'/Ui/Components',
                'views' => 'billing::components',
            ],
            'pages' => [
                'namespace' => 'Billing\Ui\Pages',
                'path' => __DIR__.'/Ui/Pages',
                'views' => 'billing::pages',
            ],
            'stores' => [
                'namespace' => 'Billing\Ui\Stores',
                'path' => __DIR__.'/Ui/Stores',
            ],
        ]);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'billing');
    }
}
