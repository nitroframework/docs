<?php

namespace App\Fusion\Components;

use Nitro\Fusion\Component;

class ReplyBox extends Component
{
    public const LIMIT = 280;

    public string $reply = '';

    public function remaining(): int
    {
        return self::LIMIT - mb_strlen($this->reply);
    }
}
