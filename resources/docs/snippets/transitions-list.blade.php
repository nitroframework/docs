@foreach ($people as $person)
    <li fusion:key="{{ $person }}" fusion:transition.move.duration.250ms>{{ $person }}</li>
@endforeach

@if ($tab === 'list')
    <section fusion:transition.out-in>...</section>
@else
    <section fusion:transition.out-in>...</section>
@endif
