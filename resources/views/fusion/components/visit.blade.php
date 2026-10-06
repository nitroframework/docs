<div class="flex w-full max-w-lg flex-wrap items-center gap-2 text-sm">
    <select fusion:model="page" class="rounded-lg bg-white px-3 py-2 ring-1 ring-zinc-300 outline-none focus:ring-2 focus:ring-violet-500 dark:bg-zinc-900 dark:ring-white/15">
        <option value="head">The page's head</option>
        <option value="page-data">Page data</option>
        <option value="pages">Pages</option>
    </select>
    <button type="button" fusion:click="$visit('/docs/' . $page)" class="rounded-lg bg-zinc-900 px-3 py-2 font-semibold text-white dark:bg-white dark:text-zinc-900">Go there with $visit</button>
    <a fusion:navigate href="/docs/introduction" class="font-medium text-violet-600 dark:text-violet-400">or a fusion:navigate link</a>
</div>
