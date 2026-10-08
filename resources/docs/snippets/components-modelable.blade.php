{{-- In the parent's view: its $startsOn, and a key under an array --}}
<fusion:date-picker fusion:model="startsOn" />
<fusion:date-picker fusion:model="booking.endsOn" />

@foreach ($stops as $i => $stop)
    <fusion:date-picker fusion:model="stops.{{ $i }}.date" :key="$stop['id']" />
@endforeach
