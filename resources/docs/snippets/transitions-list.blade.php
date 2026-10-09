@foreach ($people as $person)
    <li nitro:key="{{ $person }}" nitro:transition.move.duration.250ms>{{ $person }}</li>
@endforeach

@if ($tab === 'list')
    <section nitro:transition.out-in>...</section>
@else
    <section nitro:transition.out-in>...</section>
@endif
