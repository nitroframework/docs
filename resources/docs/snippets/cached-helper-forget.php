#[Server]
public function publish(): void
{
    $this->validate();
    Post::create([...$this->form, 'status' => 'published']);

    foreach (Post::STATUSES as $status) {
        Cache::forget("stats.categories.{$status}");
    }
}
