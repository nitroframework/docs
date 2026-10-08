{{-- resources/views/fusion/components/panel.blade.php --}}
<section class="panel">
    @if ($collapsible)
        <button fusion:click="$toggle('open')">{{ $open ? 'Hide' : 'Show' }}</button>
    @endif

    @if ($open)
        <div>{{ $slot }}</div>
    @endif

    @if ($slots->has('footer'))
        <footer>{{ $slots['footer'] }}</footer>
    @endif
</section>
