import { For } from 'solid-js';

export default function Checkout(props) {
    return (
        <>
            {/* A key inside a property: its path, as nitro:model writes it. */}
            <input value={props.form.email} onInput={(e) => props.set('form.email', e.currentTarget.value)} />
            <label>
                <input type="checkbox" checked={props.form.gift} onChange={(e) => props.set('form.gift', e.currentTarget.checked)} />
                It's a gift
            </label>

            <For each={props.lines}>
                {(line, index) => (
                    <div>
                        {line.name}
                        <input type="number" value={line.quantity}
                            onInput={(e) => props.set(`lines.${index()}.quantity`, e.currentTarget.valueAsNumber)} />
                        <button onClick={() => props.removeLine(index())}>Remove</button>
                    </div>
                )}
            </For>

            {/* Or the PHP's own method, compiled to run here. */}
            <button onClick={() => props.addLine('SKU-42')}>Add a line</button>
        </>
    );
}
