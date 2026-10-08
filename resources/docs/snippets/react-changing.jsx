export default function Checkout({ form, lines, set, addLine, removeLine }) {
    return (
        <>
            {/* A key inside a property: its path, as fusion:model writes it. */}
            <input value={form.email} onChange={(e) => set('form.email', e.target.value)} />
            <label>
                <input type="checkbox" checked={form.gift} onChange={(e) => set('form.gift', e.target.checked)} />
                It's a gift
            </label>

            {lines.map((line, index) => (
                <div key={line.sku}>
                    {line.name}
                    <input type="number" value={line.quantity}
                        onChange={(e) => set(`lines.${index}.quantity`, e.target.valueAsNumber)} />
                    <button onClick={() => removeLine(index)}>Remove</button>
                </div>
            ))}

            {/* Or the PHP's own method, compiled to run here. */}
            <button onClick={() => addLine('SKU-42')}>Add a line</button>
        </>
    );
}
