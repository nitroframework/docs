<ul class="w-full max-w-xs space-y-1 rounded-lg bg-white p-3 text-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10">
    @forelse ($items as $i => $item)
        <li class="flex justify-between">
            <span>{{ $item['name'] }}</span>
            <button type="button" nitro:click="remove($i)" class="text-slate-400 hover:text-red-500">remove</button>
        </li>
    @empty
        <li class="text-slate-400">The cart is empty</li>
    @endforelse
</ul>
