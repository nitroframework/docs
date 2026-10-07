{{-- The widget each dashboard tile names, from the database --}}
@foreach ($tiles as $tile)
    @fusion($tile->component, ['userId' => auth()->id()])
@endforeach

{{-- Starting when it comes into view --}}
@fusion('reports.chart', ['year' => 2026], [], 'visible')
