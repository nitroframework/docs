{{-- any view of the app, or of another module --}}
<nitro:billing::invoice-table />

{{-- a component in a folder of the module: Ui/Components/Reports/Summary.php --}}
<nitro:billing::reports.summary :year="2026" />
