<div class="w-full max-w-xs space-y-2 rounded-lg bg-white p-3 text-sm ring-1 ring-zinc-200 dark:bg-zinc-900 dark:ring-white/10">
    <ul class="space-y-1">
        @forelse ($cart->items as $i => $item)
            <li class="flex justify-between">
                <span>{{ $item['name'] }}</span>
                <button type="button" fusion:click="$cart->remove($i)" class="text-zinc-400 hover:text-red-500">remove</button>
            </li>
        @empty
            <li class="text-zinc-400">The cart is empty</li>
        @endforelse
    </ul>
    <div class="flex items-center justify-between border-t border-zinc-200 pt-2 dark:border-white/10">
        <span class="text-xs text-zinc-500">{{ $cart->savedAt === '' ? 'Not saved' : 'Saved at '.$cart->savedAt.': reload, it stays' }}</span>
        <button type="button" fusion:click="$cart->save()" fusion:loading.attr="disabled" class="font-semibold text-zinc-900 disabled:opacity-50 dark:text-white">Save</button>
    </div>
</div>
