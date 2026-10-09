#[Server]
public function save(): void
{
    $this->validate();
    Student::create($this->form);

    foreach (Student::STATUSES as $status) {
        Cache::forget("reports.enrolment.{$status}");
    }
}
