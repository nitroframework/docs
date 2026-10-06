<div class="w-full max-w-lg divide-y divide-zinc-200 rounded-xl bg-white ring-1 ring-zinc-200 dark:divide-white/10 dark:bg-zinc-900 dark:ring-white/10">
    @foreach ($questions as $i => $item)
        <fusion:faq-item :question="$item['question']" :answer="$item['answer']" :key="$i" />
    @endforeach
</div>
