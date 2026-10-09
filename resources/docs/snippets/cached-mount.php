<?php

namespace App\Nitro\Pages\Reports;

use App\Models\Student;
use Nitro\Attributes\Cached;
use Nitro\Attributes\Locked;
use Nitro\Attributes\Url;
use Nitro\Component;

class Enrolment extends Component
{
    #[Url]
    public string $status = 'active';

    /** @var array<string, int> students by grade */
    #[Locked]
    public array $byGrade = [];

    #[Cached(300, tags: ['students'])]
    public function mount(): void
    {
        $this->byGrade = Student::where('status', $this->status)
            ->selectRaw('grade, count(*) as students')
            ->groupBy('grade')
            ->pluck('students', 'grade')
            ->all();
    }
}
