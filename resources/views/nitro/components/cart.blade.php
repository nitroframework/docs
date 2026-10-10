<div class="grid w-full max-w-lg gap-4 text-sm sm:grid-cols-2">
    <div class="space-y-2">
        @foreach ($products as $i => $product)
            <button type="button" nitro:click="add($i)" class="flex w-full items-center justify-between rounded-lg bg-white px-3 py-2 ring-1 ring-slate-200 hover:ring-blue-400 dark:bg-slate-900 dark:ring-white/10">
                <span>{{ $product['name'] }}</span>
                <span class="text-slate-500">${{ $product['price'] }} +</span>
            </button>
        @endforeach
    </div>
    <div class="rounded-lg bg-white p-3 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
        <ul class="space-y-1">
            @forelse ($items as $i => $item)
                <li class="flex justify-between">
                    <span>{{ $item['name'] }}</span>
                    <button type="button" nitro:click="remove($i)" class="text-slate-400 hover:text-red-500">remove</button>
                </li>
            @empty
                <li class="text-slate-400">The cart is empty</li>
            @endforelse
        </ul>
        <dl class="mt-3 space-y-1 border-t border-slate-200 pt-3 dark:border-white/10">
            <div class="flex justify-between"><dt>Subtotal</dt><dd>${{ $this->subtotal }}</dd></div>
            <div class="flex justify-between"><dt>Delivery</dt><dd>{{ $this->delivery === 0 ? 'free' : '$'.$this->delivery }}</dd></div>
            <div class="flex justify-between font-semibold text-slate-900 dark:text-white"><dt>Total</dt><dd>${{ $this->subtotal + $this->delivery }}</dd></div>
        </dl>
        @if ($this->subtotal > 0 && $this->subtotal < 30)
            <p class="mt-2 text-xs text-slate-500">Free delivery from $30: ${{ 30 - $this->subtotal }} to go</p>
        @endif
        <input nitro:model.blur="postcode" placeholder="Postcode (try  sw1a   1aa)" class="mt-3 w-full rounded-md bg-transparent px-2 py-1 ring-1 ring-slate-300 outline-none focus:ring-blue-500 dark:ring-white/15">
    </div>
</div>
