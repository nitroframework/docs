use App\Fusion\Components\Counter;

public function test_save_keeps_the_count(): void
{
    $counter = new Counter;
    $counter->count = 7;

    $counter->save();

    $this->assertSame(7, session('counter.count'));
    $this->assertNotSame('', $counter->savedAt);
}
