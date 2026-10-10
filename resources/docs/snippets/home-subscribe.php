#[Validate('required|email')]
public string $email = '';

#[Server]
public function subscribe(): void
{
    $this->validate();

    Subscriber::create(['email' => $this->email]);
}
