<template>
    <form class="space-y-3 rounded-xl bg-white p-4 ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-white/10" @submit.prevent="save">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ postId === null ? 'New post' : 'Edit post' }}</h3>
            <button v-if="postId !== null" type="button" class="text-xs font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white" @click="cancel">Cancel</button>
        </div>

        <div>
            <input v-model="title" maxlength="120" placeholder="Title" aria-label="Title" class="w-full rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900">
            <p v-if="errors.title" class="mt-1 text-xs text-red-600 dark:text-red-400">{{ errors.title[0] }}</p>
        </div>

        <div>
            <textarea v-model="body" rows="6" maxlength="2000" placeholder="Write something…" aria-label="Body" class="w-full resize-y rounded-lg bg-slate-50 px-3 py-2 text-sm leading-6 ring-1 ring-slate-200 outline-none placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-browser-500 dark:bg-white/5 dark:ring-white/10 dark:focus:bg-slate-900"></textarea>
            <p v-if="errors.body" class="mt-1 text-xs text-red-600 dark:text-red-400">{{ errors.body[0] }}</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-500">{{ words }} {{ words === 1 ? 'word' : 'words' }}</span>
            <span v-if="notice" class="text-xs font-medium text-emerald-600 dark:text-emerald-400">{{ notice }}</span>
            <button :disabled="save.processing" class="ml-auto rounded-lg bg-browser-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-browser-500 disabled:opacity-50">{{ postId === null ? 'Publish' : 'Update' }}</button>
        </div>
    </form>
</template>
