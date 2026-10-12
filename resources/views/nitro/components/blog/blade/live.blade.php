<div>
    @if (count($feed) === 0)
        <p class="py-6 text-center text-sm text-slate-500">Open this page in a second tab and publish there: the post shows up here.</p>
    @else
        <ul class="space-y-2.5">
            @foreach ($feed as $event)
                <li class="flex items-start gap-2.5 text-sm">
                    <span class="mt-1.5 size-2 shrink-0 rounded-full bg-server-500"></span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-slate-700 dark:text-slate-300">{{ $event['created'] ? 'Published' : 'Updated' }} “{{ $event['title'] }}”</span>
                        <span class="text-[11px] text-slate-400">through Reverb at {{ $event['at'] }}</span>
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
