#[Validate('required|email|max:120', as: 'email')]
public string $email = '';

#[Validate(['tags' => 'array|max:3', 'tags.*' => 'string|min:2'])]
public array $tags = [];

#[Server]
public function submit(): void
{
    $this->validate();                                    // Checks every property's #[Validate] rules.
    $this->validate(['coupon' => 'nullable|alpha_num']);  // Or checks rules of its own.
}
