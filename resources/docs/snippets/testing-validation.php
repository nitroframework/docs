use App\Fusion\Components\PostEditor;
use Illuminate\Validation\ValidationException;

public function test_a_post_needs_a_title(): void
{
    $editor = new PostEditor;
    $editor->title = '';

    $this->assertThrows(fn () => $editor->save(), ValidationException::class);
}

public function test_the_messages_are_the_ones_shown(): void
{
    $editor = new PostEditor;
    $editor->title = 'Hi';

    try {
        $editor->save();
        $this->fail('A two-letter title was accepted.');
    } catch (ValidationException $exception) {
        $this->assertSame(['The title field must be at least 3 characters.'], $exception->errors()['title']);
    }
}
