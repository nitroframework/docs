<form nitro:submit="submit" class="w-full max-w-sm space-y-3 text-sm">
    @if ($welcome !== '')
        <p class="rounded-lg bg-emerald-50 px-3 py-2 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20">{{ $welcome }}</p>
    @endif

    <label class="block space-y-1">
        <span class="font-medium">Name</span>
        <input nitro:model.trim="name" @class(['w-full rounded-lg bg-white px-3 py-2 ring-1 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900', 'ring-red-400' => $errors->has('name'), 'ring-slate-300 dark:ring-white/15' => ! $errors->has('name')])>
        @error('name') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
    </label>

    <label class="block space-y-1">
        <span class="font-medium">Email</span>
        <input type="email" nitro:model.blur="email" @class(['w-full rounded-lg bg-white px-3 py-2 ring-1 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900', 'ring-red-400' => $errors->has('email'), 'ring-slate-300 dark:ring-white/15' => ! $errors->has('email')])>
        @if (! $this->emailLooksRight)
            <span class="text-xs text-amber-600 dark:text-amber-400">That does not look like an email address yet.</span>
        @endif
        @error('email') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
    </label>

    <div class="flex gap-4">
        @foreach (['starter' => 'Starter', 'team' => 'Team'] as $value => $label)
            <label class="flex items-center gap-2">
                <input type="radio" value="{{ $value }}" nitro:model="plan"> {{ $label }}
            </label>
        @endforeach
    </div>

    <label class="flex items-center gap-2">
        <input type="checkbox" nitro:model="terms"> I accept the terms
    </label>
    @error('terms') <span class="block text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror

    <button class="rounded-lg bg-slate-900 px-3 py-2 font-semibold text-white disabled:opacity-50 dark:bg-white dark:text-slate-900" nitro:loading.attr="disabled">
        <span nitro:loading.remove>Sign up</span>
        <span nitro:loading>Signing up…</span>
    </button>
</form>
