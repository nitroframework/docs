{{-- resources/views/fusion/pages/payments.blade.php: one page, three engines --}}
<x-layouts.app>
    <h1>Payments</h1>

    <div class="grid grid-cols-3 gap-6">
        <fusion:vue.payment-desk />                     {{-- picks a student, records a payment --}}
        <fusion:react.student-card />                   {{-- hears both, and shows the balance --}}
        <fusion:payments.recent :limit="10" />          {{-- a Blade view, hearing the same events --}}
    </div>
</x-layouts.app>
