public ?Upload $photo = null;

#[Server]
public function save(): void
{
    $this->validate(['photo' => 'required|image|max:2048']);

    $this->photo->store('photos', 'public');
}
