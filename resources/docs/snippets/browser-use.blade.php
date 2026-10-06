{{-- One class --}}
@use('App\Support\Money')

{{-- One class, under another name --}}
@use('App\Support\Money', 'Cash')

{{-- Several classes from one namespace --}}
@use('App\Enums\{OrderStatus, Priority}')

<p>{{ Money::format($total) }}</p>
