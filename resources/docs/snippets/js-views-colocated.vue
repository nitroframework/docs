<php>
use App\Models\Invoice;

new class extends Component {
    #[Locked]
    public int $invoiceId;

    public array $lines = [['item' => '', 'amount' => 0]];

    #[Computed]
    public function total(): int
    {
        return array_sum(array_column($this->lines, 'amount'));
    }

    public function addLine(): void
    {
        $this->lines[] = ['item' => '', 'amount' => 0];
    }

    #[Server]
    public function save(): void
    {
        Invoice::findOrFail($this->invoiceId)->update(['lines' => $this->lines, 'total' => $this->total()]);
    }
};
</php>

<template>
    <div class="invoice">
        <div v-for="(line, i) in lines" :key="i">
            <input v-model="line.item"> <input v-model.number="line.amount" type="number">
        </div>
        <button @click="addLine">Add a line</button>
        <p>Total: {{ total }}</p>
        <button :disabled="save.processing" @click="save()">Save</button>
    </div>
</template>
