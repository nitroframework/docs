<div class="space-y-2 text-sm">
    <button type="button" nitro:click="$toggle('open')" class="rounded-lg px-3 py-1.5 font-medium ring-1 ring-zinc-300 dark:ring-white/15">
        {{ $open ? 'Close the cart' : 'Open the cart' }}
    </button>
    @if ($open)
        <nitro:shop-cart />
    @endif
</div>
