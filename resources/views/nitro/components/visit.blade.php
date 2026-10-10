<div class="flex w-full max-w-lg flex-wrap items-center gap-2 text-sm">
    <select nitro:model="page" class="rounded-lg bg-white px-3 py-2 ring-1 ring-slate-300 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:ring-white/15">
        <option value="head">The page's head</option>
        <option value="page-data">Page data</option>
        <option value="pages">Pages</option>
    </select>
    <button type="button" nitro:click="$visit('/docs/' . $page)" class="rounded-lg bg-slate-900 px-3 py-2 font-semibold text-white dark:bg-white dark:text-slate-900">Go there with $visit</button>
    <a nitro:navigate href="/docs/introduction" class="font-medium text-blue-600 dark:text-blue-400">or a nitro:navigate link</a>
</div>
