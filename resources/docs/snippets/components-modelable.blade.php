{{-- In the parent's view: its $startsOn, and a key under an array --}}
<nitro:date-picker nitro:model="startsOn" />
<nitro:date-picker nitro:model="booking.endsOn" />

@foreach ($stops as $i => $stop)
    <nitro:date-picker nitro:model="stops.{{ $i }}.date" :key="$stop['id']" />
@endforeach
