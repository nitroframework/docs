#[Validate([
    'lines' => 'required|array|max:50',
    'lines.*.description' => 'required|max:200',
    'lines.*.quantity' => 'integer|min:1|max:999',
    'lines.*.price' => 'integer|min:0',          // In pence, typed in by the user.
])]
public array $lines = [
    ['description' => '', 'quantity' => 1, 'price' => 0],
];

public function addLine(): void
{
    $this->lines[] = ['description' => '', 'quantity' => 1, 'price' => 0];
}

public function removeLine(int $i): void
{
    array_splice($this->lines, $i, 1);
}

#[Computed]
public function total(): int
{
    return array_sum(array_map(fn (array $line) => $line['quantity'] * $line['price'], $this->lines));
}

#[Server]
public function save(): void
{
    $this->validate();

    auth()->user()->invoices()->create([
        'lines' => $this->lines,
        'total' => $this->total,      // Worked out again here, from the validated lines.
    ]);
}
