public string $status = 'active';

public string $grade = '';

/** @var list<string> */
public array $names = [];

#[Server]
#[Cached(300, tags: ['students'], by: ['status'])]
public function lookUp(string $grade): void
{
    $this->grade = $grade;
    $this->names = Student::where('status', $this->status)
        ->where('grade', $grade)
        ->orderBy('name')
        ->pluck('name')
        ->all();
}
