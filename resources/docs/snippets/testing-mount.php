use App\Nitro\Pages\Students\Show;
use App\Models\Student;

public function test_a_student_page_lists_what_they_owe(): void
{
    $student = Student::factory()->hasInvoices(2, ['status' => 'sent'])->create();

    $page = new Show;
    $page->mount($student);    // as the route calls it, with the bound model

    $this->assertCount(2, $page->unpaid);
}
