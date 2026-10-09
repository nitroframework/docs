@foreach ($lines as $i => $line)
    <div>
        <input nitro:model="lines.{{ $i }}.description">
        <input type="number" nitro:model.number="lines.{{ $i }}.quantity">
        <span>{{ number_format($line['quantity'] * $line['price'] / 100, 2) }}</span>
        <button nitro:click="removeLine($i)">Remove</button>
    </div>
@endforeach

<button nitro:click="addLine">Add a line</button>
<p>Total: {{ number_format($this->total / 100, 2) }}</p>
