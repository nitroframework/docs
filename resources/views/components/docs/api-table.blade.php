@props(['rows', 'columns' => ['Name', 'Type', 'Default', 'Description']])

{{--
    Reference rows: [name, type, default, description, runs?]. With two columns, a row is
    [name, description, runs?]: the name with its badge, and what it does.
--}}
@php
    $short = count($columns) === 2;
@endphp

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
                @php $runs = $short ? ($row[2] ?? null) : ($row[4] ?? null); @endphp
                <tr class="align-top">
                    <td @class(['px-4 py-3', 'whitespace-nowrap' => ! $short])>
                        <code class="font-mono text-[13px] font-semibold text-zinc-900 dark:text-white">{{ $row[0] }}</code>
                        @if ($runs)<x-docs.badge :runs="$runs" class="ml-2 align-middle" />@endif
                    </td>
                    @unless ($short)
                        <td class="px-4 py-3 font-mono text-[13px] whitespace-nowrap text-browser-700 dark:text-browser-300">{{ $row[1] }}</td>
                        <td class="px-4 py-3 font-mono text-[13px] whitespace-nowrap text-zinc-500">{{ $row[2] }}</td>
                    @endunless
                    <td class="px-4 py-3 leading-6 text-zinc-600 dark:text-zinc-400">{{ $short ? $row[1] : $row[3] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
