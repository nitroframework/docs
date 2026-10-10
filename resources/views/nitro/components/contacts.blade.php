<div class="w-full max-w-md space-y-3 text-sm">
    <input nitro:model="search" placeholder="Search by name" class="w-full rounded-lg bg-white px-3 py-2 ring-1 ring-slate-300 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:ring-white/15">

    <ul class="divide-y divide-slate-200 rounded-lg bg-white ring-1 ring-slate-200 dark:divide-white/10 dark:bg-slate-900 dark:ring-white/10">
        @forelse ($this->found as $contact)
            <li @class(['flex items-center justify-between px-3 py-2', 'bg-blue-50 dark:bg-blue-500/10' => $loop->first && $search !== ''])>
                <span>
                    <span class="font-medium text-slate-900 dark:text-white">{{ Str::title($contact['name']) }}</span>
                    <span class="text-slate-500">· {{ Str::headline($contact['role']) }}</span>
                </span>
                <span class="font-mono text-xs text-slate-400">{{ Str::mask($contact['phone'], '•', 0, 8) }}</span>
            </li>
        @empty
            <li class="px-3 py-2 text-slate-400">No one is called “{{ $search }}”</li>
        @endforelse
    </ul>
    <p class="text-xs text-slate-500">{{ count($this->found) }} of {{ count($contacts) }} contacts</p>
</div>
