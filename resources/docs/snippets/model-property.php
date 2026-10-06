public ?Post $post = null;

public function mount(Post $post): void
{
    $this->post = $post;
}
