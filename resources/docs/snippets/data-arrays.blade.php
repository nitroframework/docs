@foreach ($lines as $i => $line)
    <div>
        <input fusion:model="lines.{{ $i }}.description">
        <input type="number" fusion:model.number="lines.{{ $i }}.quantity">
        <span>{{ number_format($line['quantity'] * $line['price'] / 100, 2) }}</span>
        <button fusion:click="removeLine($i)">Remove</button>
    </div>
@endforeach

<button fusion:click="addLine">Add a line</button>
<p>Total: {{ number_format($this->total / 100, 2) }}</p>
