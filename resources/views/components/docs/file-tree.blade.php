@props(['tree'])

@php
    /**
     * One line per entry, indented by two spaces per level: "app/" is a folder, "* Counter.php"
     * an entry to point at, "# ..." after an entry a note.
     */
    $rows = [];
    foreach (explode("\n", trim($tree, "\n")) as $line) {
        $depth = intdiv(strlen($line) - strlen(ltrim($line)), 2);
        $text = trim($line);
        $marked = str_starts_with($text, '* ');
        $text = $marked ? substr($text, 2) : $text;
        [$name, $note] = array_pad(array_map('trim', explode('#', $text, 2)), 2, null);
        $rows[] = ['depth' => $depth, 'name' => rtrim($name, '/'), 'folder' => str_ends_with($name, '/'), 'marked' => $marked, 'note' => $note];
    }
@endphp

<div {{ $attributes->class('not-prose my-6 rounded-xl bg-slate-50/80 px-4 py-3.5 font-mono text-[13px] leading-7 ring-1 ring-slate-200 dark:bg-slate-900/70 dark:ring-white/10') }}>
    @foreach ($rows as $row)
        <div class="flex items-center gap-2" style="padding-left: {{ $row['depth'] * 1.25 }}rem">
            @if ($row['folder'])
                <svg class="size-4 shrink-0 text-slate-400" viewBox="0 0 16 16" fill="currentColor" fill-opacity=".25" stroke="currentColor" stroke-width="1.2"><path d="M1.75 4.25a1 1 0 0 1 1-1h3.4l1.4 1.5h5.7a1 1 0 0 1 1 1v6.5a1 1 0 0 1-1 1H2.75a1 1 0 0 1-1-1v-8Z" stroke-linejoin="round"/></svg>
            @else
                <svg class="size-4 shrink-0 {{ $row['marked'] ? 'text-browser-500' : 'text-slate-400' }}" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M9 1.75H4.25a1 1 0 0 0-1 1v10.5a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V5.25L9 1.75Z" stroke-linejoin="round"/></svg>
            @endif
            <span @class(['font-semibold text-slate-900 dark:text-white' => $row['marked'], 'text-slate-700 dark:text-slate-300' => ! $row['marked']])>{{ $row['name'] }}</span>
            @if ($row['note'])
                <span class="font-sans text-xs text-slate-400 dark:text-slate-500">{{ $row['note'] }}</span>
            @endif
        </div>
    @endforeach
</div>
