#[Validate('required|email|unique:users,email', as: 'email address', onBlur: true)]
public string $email = '';

#[Validate('required|min:12|confirmed', onBlur: true)]
public string $password = '';

public string $password_confirmation = '';

#[Server]
public function register(): void
{
    $data = $this->validate();
    User::create($data);
}
