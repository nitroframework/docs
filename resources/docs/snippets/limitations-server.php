// A browser method: the build fails, because the clock belongs to the server.
public function stamp(): void
{
    $this->savedAt = now()->toTimeString();
}

// A #[Server] method runs on the server, where now() is available.
#[Server]
public function stamp(): void
{
    $this->savedAt = now()->toTimeString();
}
