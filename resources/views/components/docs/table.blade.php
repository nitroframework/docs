@props(['columns', 'rows'])

{{-- A plain table: text cells, `backticks` shown as code, the first column as the row's label. --}}
<div {{ $attributes->class('not-prose my-6 overflow-x-auto rounded-xl ring-1 ring-zinc-200 dark:ring-white/10') }}>
    <table class="w-full text-left text-sm">
        <thead class="bg-zinc-50/80 text-xs font-semibold text-zinc-500 dark:bg-white/[0.03] dark:text-zinc-400">
            <tr>
                @foreach ($columns as $column)
                    <th class="px-4 py-2.5 whitespace-nowrap">{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-200/80 dark:divide-white/[0.07]">
            @foreach ($rows as $row)
                <tr class="align-top">
                    @foreach ($row as $i => $cell)
                        <td @class(['px-4 py-3 leading-6', 'font-medium text-zinc-900 dark:text-white' => $i === 0, 'text-zinc-600 dark:text-zinc-400' => $i > 0])>
                            @foreach (preg_split('/(`[^`]+`)/', (string) $cell, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY) as $part)
                                @if (str_starts_with($part, '`') && str_ends_with($part, '`'))
                                    <code class="rounded bg-zinc-100 px-1 py-0.5 font-mono text-[12.5px] text-zinc-800 dark:bg-white/[0.06] dark:text-zinc-200">{{ substr($part, 1, -1) }}</code>
                                @else
                                    {{ $part }}
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
