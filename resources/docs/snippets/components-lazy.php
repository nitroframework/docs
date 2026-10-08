use Nitro\Fusion\Attributes\LazyLoad;

#[LazyLoad]                 // its own chunk, loaded when a page first shows it
class ReportBuilder extends Component { /* ... */ }

#[LazyLoad('charts')]       // one chunk for the three: one request for whichever shows first
class RevenueChart extends Component { /* ... */ }

#[LazyLoad('charts')]
class SignupsChart extends Component { /* ... */ }

#[LazyLoad('charts')]
class ChurnChart extends Component { /* ... */ }
