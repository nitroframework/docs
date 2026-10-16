@props(['full' => false])

@if ($full)
    {{-- The full footer: where to go next in the docs, and the project. --}}
    @php
        $columns = [
            'Get started' => ['introduction' => 'Introduction', 'installation' => 'Installation', 'quickstart' => 'Quickstart', 'how-it-works' => 'How Nitro works'],
            'Build' => ['components' => 'Components', 'server-methods' => 'Server methods', 'forms' => 'Forms and validation', 'navigation' => 'Navigation'],
            'Go further' => ['javascript-views' => 'JavaScript views', 'hooks' => 'Hooks', 'testing' => 'Testing', 'production' => 'Building for production'],
        ];
    @endphp
    <footer class="border-t border-slate-900/[0.06] dark:border-white/[0.06]">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr_1fr] lg:px-8">
            <div>
                <x-docs.logo />
                <p class="mt-4 max-w-xs text-sm leading-6 text-slate-500">PHP components for Laravel that run in the browser. Free and open source, under the MIT license.</p>
                <p class="mt-4 inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 font-mono text-xs text-slate-600 dark:bg-white/5 dark:text-slate-400">nitro/nitro {{ config('docs.version') }}</p>
            </div>
            @foreach ($columns as $heading => $pages)
                <div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $heading }}</p>
                    <ul class="mt-4 space-y-2.5 text-sm">
                        @foreach ($pages as $slug => $title)
                            <li><a nitro:navigate href="/docs/{{ $slug }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-white">{{ $title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Project</p>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a nitro:navigate href="/blog" class="text-slate-500 hover:text-slate-900 dark:hover:text-white">Blog</a></li>
                    <li><a href="{{ config('docs.github') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-white">GitHub</a></li>
                    <li><a href="{{ config('docs.github') }}/releases" class="text-slate-500 hover:text-slate-900 dark:hover:text-white">Releases</a></li>
                    <li><a href="{{ config('docs.github') }}/issues" class="text-slate-500 hover:text-slate-900 dark:hover:text-white">Issues</a></li>
                    <li><a href="{{ config('docs.sponsor') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-white">Sponsor</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-slate-900/[0.06] dark:border-white/[0.06]">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-6 py-6 text-xs text-slate-500 sm:flex-row lg:px-8">
                <x-docs.credits />
                <span>MIT license · {{ config('docs.version') }}</span>
            </div>
        </div>
    </footer>
@else
    <footer class="border-t border-slate-900/[0.06] dark:border-white/[0.06]">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 py-10 text-sm text-slate-500 sm:flex-row lg:px-8">
            <div class="flex flex-col items-center gap-2 sm:flex-row sm:gap-4">
                <x-docs.logo class="scale-90 opacity-80" />
                <x-docs.credits class="text-xs" />
            </div>
            <nav class="flex gap-6">
                <a nitro:navigate href="/docs" class="hover:text-slate-900 dark:hover:text-white">Docs</a>
                <a nitro:navigate href="/blog" class="hover:text-slate-900 dark:hover:text-white">Blog</a>
                <a href="{{ config('docs.github') }}" class="hover:text-slate-900 dark:hover:text-white">GitHub</a>
                <a href="{{ config('docs.sponsor') }}" class="hover:text-slate-900 dark:hover:text-white">Sponsor</a>
            </nav>
        </div>
    </footer>
@endif
