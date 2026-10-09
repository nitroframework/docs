<?php

namespace App\Nitro\Components;

use Nitro\Attributes\Locked;
use Nitro\Attributes\Server;
use Nitro\Component;
use Nitro\Upload;

class PhotoCheck extends Component
{
    public ?Upload $photo = null;

    #[Locked]
    public string $result = '';

    #[Server]
    public function check(): void
    {
        $this->validate(['photo' => 'required|image|max:2048']);
        [$width, $height] = getimagesize($this->photo->getRealPath());

        // A demo: the photo is checked, not kept. Your app would store it with $this->photo->store('photos', 'public').
        $this->result = "{$this->photo->getClientOriginalName()}: {$width} × {$height} pixels, ".number_format($this->photo->getSize() / 1024, 1).' KB, checked on the server.';
        $this->reset('photo');
    }
}
