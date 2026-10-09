use Nitro\Facades\Nitro;

#[Server]
public function save(): void
{
    $this->validate();
    Student::create($this->form);

    Nitro::expire('students');   // Every result kept under 'students' is worked out again.
}
