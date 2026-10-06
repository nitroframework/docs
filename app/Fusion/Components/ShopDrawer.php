<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Component;

/** Opens the cart when asked. The cart component is created only then, so it misses the earlier events. */
class ShopDrawer extends Component
{
    public bool $open = false;
}
