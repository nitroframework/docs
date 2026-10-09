use Nitro\Facades\Nitro;

#[Server]
public function publish(): void
{
    $this->validate();
    Post::create([...$this->form, 'status' => 'published']);

    Nitro::expire('posts');   // Every result kept under 'posts' is worked out again.
}
