use Nitro\Attributes\LazyLoad;
use Nitro\Attributes\View;

#[View(vue: 'charts/revenue')]   // its view is resources/views/vue/charts/revenue.vue
#[LazyLoad]                       // its code loads when a page first needs it
class RevenueChart extends Component
{
    // ...
}
