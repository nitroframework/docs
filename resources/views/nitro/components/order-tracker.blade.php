@use('App\Enums\OrderStatus')
@use('App\Support\Money')
<div class="w-full max-w-md space-y-4 text-sm">
    <ul class="divide-y divide-slate-200 dark:divide-white/10">
        @foreach ($lines as $line)
            <li class="flex justify-between py-1.5">
                <span>{{ $line['quantity'] }} × {{ $line['name'] }}</span>
                <span class="tabular-nums">{{ Money::format($line['price'] * $line['quantity']) }}</span>
            </li>
        @endforeach
        <li class="flex justify-between py-1.5 font-semibold">
            <span>Total</span>
            <span class="tabular-nums">{{ Money::format($this->total) }}</span>
        </li>
    </ul>

    <div class="flex flex-wrap items-center gap-3">
        <select nitro:model="status" class="rounded-lg bg-white px-2.5 py-1.5 ring-1 ring-slate-300 dark:bg-slate-900 dark:ring-white/15" aria-label="Status">
            @foreach (OrderStatus::cases() as $case)
                <option value="{{ $case->value }}">{{ $case->label() }}</option>
            @endforeach
        </select>
        <button type="button" nitro:click="advance" @disabled($status->isFinal()) class="rounded-lg px-3 py-1.5 font-semibold ring-1 ring-slate-300 disabled:opacity-40 dark:ring-white/15">
            Next step
        </button>
        <button type="button" nitro:click="save" nitro:loading.attr="disabled" class="rounded-lg bg-slate-900 px-3 py-1.5 font-semibold text-white disabled:opacity-50 dark:bg-white dark:text-slate-900">
            Save on the server
        </button>
    </div>

    <p class="text-slate-500">
        {{ $status->isFinal() ? 'This order is complete.' : 'Next: '.$status->next()->label() }}
        · {{ $savedAt === '' ? 'Not saved yet' : 'Saved at '.$savedAt.': reload, it stays' }}
    </p>
</div>
