use Nitro\Fusion\Attributes\LazyLoad;

#[LazyLoad(false)]       // In the main bundle, so the first visit has no chunk to load.
class Dashboard extends Component

#[LazyLoad('reports')]   // One chunk for pages and components that are used together.
class Revenue extends Component
