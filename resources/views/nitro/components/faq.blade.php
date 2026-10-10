<div class="w-full max-w-lg divide-y divide-slate-200 rounded-xl bg-white ring-1 ring-slate-200 dark:divide-white/10 dark:bg-slate-900 dark:ring-white/10">
    @foreach ($questions as $i => $item)
        <nitro:faq-item :question="$item['question']" :answer="$item['answer']" :key="$i" />
    @endforeach
</div>
