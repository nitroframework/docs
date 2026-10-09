use Nitro\Attributes\LazyLoad;

#[LazyLoad('comments')]     // Its code is downloaded only when one of its islands starts.
class Comments extends Component
