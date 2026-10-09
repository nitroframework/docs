#[Validate('required|alpha_dash|min:3|max:30')]
public string $username = '';

public string $availability = '';

/**
 * On the server, after the view changes $username (nitro:model.debounce.400ms="username").
 * Its #[Validate] rule is checked first: a name that fails it never gets here.
 */
#[Server]
public function updatedUsername(string $value): void
{
    $this->availability = User::where('username', $value)->exists() ? 'Taken' : 'Available';
}
