use Nitro\Testing\AssertableNitro;
use Nitro\Testing\InteractsWithNitro;

class PostPageTest extends TestCase
{
    use InteractsWithNitro, RefreshDatabase;

    public function test_a_comment_is_added(): void
    {
        $post = Post::factory()->create();
        $page = $this->actingAs(User::factory()->create())->get("/posts/{$post->id}");

        $this->callNitro($page, 'addComment', updates: ['comment' => 'Nice post'])
            ->assertOk()
            ->assertNitro(fn (AssertableNitro $state) => $state->hasNoErrors()->where('comment', ''));

        $this->assertSame(1, $post->comments()->count());
    }

    public function test_an_empty_comment_is_refused(): void
    {
        $page = $this->actingAs(User::factory()->create())->get('/posts/'.Post::factory()->create()->id);

        $this->callNitro($page, 'addComment', updates: ['comment' => ''])
            ->assertNitro(fn (AssertableNitro $state) => $state->hasErrors('comment'));
    }
}
