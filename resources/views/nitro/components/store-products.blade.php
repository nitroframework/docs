<div class="flex w-full max-w-lg flex-wrap gap-2 text-sm">
    @foreach ($products as $product)
        <button type="button" nitro:click="$cart->add($product)" class="rounded-lg bg-white px-3 py-2 ring-1 ring-zinc-200 hover:ring-violet-400 dark:bg-zinc-900 dark:ring-white/10">
            {{ $product['name'] }} <span class="text-zinc-500">${{ $product['price'] }} +</span>
        </button>
    @endforeach
</div>
