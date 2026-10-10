<div class="flex w-full max-w-lg flex-wrap gap-2 text-sm">
    @foreach ($products as $i => $product)
        <button type="button" nitro:click="add($i)" class="rounded-lg bg-white px-3 py-2 ring-1 ring-slate-200 hover:ring-blue-400 dark:bg-slate-900 dark:ring-white/10">
            {{ $product['name'] }} <span class="text-slate-500">${{ $product['price'] }} +</span>
        </button>
    @endforeach
</div>
