@props(['lead' => null])

{{-- A docs page's content: its lead goes to the page (App\Docs\Content), the rest is its body. --}}
@php
    \App\Docs\Content::$lead = $lead;
@endphp
{{ $slot }}
