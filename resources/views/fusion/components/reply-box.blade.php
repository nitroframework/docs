<div class="w-full max-w-md space-y-2 text-sm">
    <textarea fusion:model="reply" fusion:autosize="8" rows="2" placeholder="Write a reply. The box grows as you type, up to eight lines."
        class="block w-full resize-none rounded-lg bg-white px-3 py-2 leading-6 ring-1 ring-zinc-300 outline-none dark:bg-zinc-900 dark:ring-white/15"></textarea>
    <p @class(['text-xs', 'text-red-600 dark:text-red-400' => $this->remaining() < 0, 'text-zinc-500' => $this->remaining() >= 0])>
        {{ $this->remaining() }} characters left
    </p>
</div>
