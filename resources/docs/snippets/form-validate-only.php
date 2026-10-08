#[Validate(['account.email' => 'required|email|unique:users,email', 'account.password' => 'required|min:12'])]
public array $account = ['email' => '', 'password' => ''];

#[Validate(['profile.name' => 'required|max:80', 'profile.company' => 'nullable|max:120'])]
public array $profile = ['name' => '', 'company' => ''];

public int $step = 1;

/** Next: this step's fields only; the profile is checked on the step that asks for it. */
#[Server]
public function next(): void
{
    $this->validateOnly($this->step === 1 ? 'account' : 'profile');
    $this->step++;
}

/** The last step: everything, before anything is saved. */
#[Server]
public function finish(): void
{
    $this->validate();
    User::register($this->account, $this->profile);
    $this->redirect('/welcome', navigate: true);
}
