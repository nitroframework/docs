<div class="card">
    {{ $slot }}

    @if ($slots->has('footer'))
        <footer>{{ $slots['footer'] }}</footer>
    @endif
</div>
