use App\Nitro\Pages\Posts\Show;
use App\Models\Post;

public function test_a_post_page_shows_its_comments(): void
{
    $post = Post::factory()->hasComments(2)->create();

    $page = new Show;
    $page->mount($post);    // as the route calls it, with the bound model

    $this->assertCount(2, $page->comments);
}
