@props(['title', 'framework', 'note' => null])

<section {{ $attributes->class('rounded-2xl bg-white/90 p-4 ring-1 ring-slate-200 dark:bg-slate-900/90 dark:ring-white/10') }}>
    <header class="mb-3 flex items-center gap-2">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
        <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ match ($framework) {
            'Blade' => 'bg-amber-100 text-amber-800 dark:bg-amber-400/10 dark:text-amber-300',
            'Vue' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-400/10 dark:text-emerald-300',
            'React' => 'bg-sky-100 text-sky-800 dark:bg-sky-400/10 dark:text-sky-300',
            'Solid' => 'bg-blue-100 text-blue-800 dark:bg-blue-400/10 dark:text-blue-300',
            default => 'bg-orange-100 text-orange-800 dark:bg-orange-400/10 dark:text-orange-300',
        } }}">{{ $framework }}</span>
        @if ($note)
            <span class="ml-auto hidden text-[11px] text-slate-400 sm:inline">{{ $note }}</span>
        @endif
    </header>
    {{ $slot }}
</section>
