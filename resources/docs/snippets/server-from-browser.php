public function finish(): void   // Runs in the browser.
{
    $this->step = 'done';
    $this->save();               // Calls a #[Server] method as a statement.
}
