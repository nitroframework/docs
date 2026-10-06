namespace App\Fusion\Pages\Students;

use App\Models\Student;
use Nitro\Fusion\Attributes\Layout;
use Nitro\Fusion\Attributes\Locked;
use Nitro\Fusion\Attributes\Server;
use Nitro\Fusion\Attributes\Title;
use Nitro\Fusion\Component;

#[Title('Student')]
#[Layout('components.layouts.app')]
class Show extends Component
{
    #[Locked]
    public array $student = [];

    public string $note = '';

    public function mount(Student $student): void
    {
        $this->student = $student->toArray();
    }

    #[Server]
    public function addNote(): void
    {
        $this->validate(['note' => 'required|max:500']);
        Student::findOrFail($this->student['id'])->notes()->create(['body' => $this->note]);
        $this->reset('note');
    }
}
