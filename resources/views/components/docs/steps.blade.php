{{-- Numbered steps: each child <x-docs.step title="..."> is one, joined by a line. --}}
<ol {{ $attributes->class('not-prose relative my-8 ml-3.5 space-y-8 border-l border-slate-200 [counter-reset:step] dark:border-white/10') }}>
    {{ $slot }}
</ol>
