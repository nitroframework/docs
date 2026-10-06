#[On('reordered')]
public function reorder(array $ids): void
{
    $this->order = $ids;
}
