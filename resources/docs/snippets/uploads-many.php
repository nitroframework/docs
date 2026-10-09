use Nitro\Attributes\Uploads;
use Nitro\Upload;

public ?Upload $photo = null;   // One file, from <input type="file" nitro:model="photo">

#[Uploads]
public array $photos = [];      // Several files, from <input type="file" multiple nitro:model="photos">

#[Server]
public function save(): void
{
    $this->validate(['photos' => 'max:5', 'photos.*' => 'image|max:2048']);

    foreach ($this->photos as $photo) {
        $photo->store('gallery', 'public');
    }

    $this->reset('photos');
}
