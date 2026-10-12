<div>
    @if ($post === null)
        <p class="py-6 text-center text-sm text-slate-500">Deleted. Publish another and it shows here.</p>
    @else
        <p class="text-xs text-slate-500">{{ $post['date'] }}</p>
        <p class="mt-1 truncate font-semibold text-slate-900 dark:text-white">{{ $post['title'] }}</p>
        <p class="mt-1 line-clamp-3 text-sm leading-6 whitespace-pre-line text-slate-600 dark:text-slate-400">{{ $post['body'] }}</p>
    @endif
</div>
