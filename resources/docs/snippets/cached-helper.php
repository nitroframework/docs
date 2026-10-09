use Illuminate\Support\Facades\Cache;

public function mount(): void
{
    Gate::authorize('viewReports', Student::class);   // Runs on every request.
    $this->head()->description("Students by grade, {$this->status}");

    $this->byGrade = $this->byGrade($this->status);   // Only this is kept.
}

/** The slow part, kept for five minutes per status. A private helper is never compiled for the browser. */
private function byGrade(string $status): array
{
    return Cache::remember("reports.enrolment.{$status}", 300, fn () => Student::where('status', $status)
        ->selectRaw('grade, count(*) as students')
        ->groupBy('grade')
        ->pluck('students', 'grade')
        ->all());
}
