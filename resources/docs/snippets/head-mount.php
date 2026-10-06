public function mount(Invoice $invoice): void
{
    $this->head()
        ->title("Invoice {$invoice->number}")
        ->description("Invoice for {$invoice->student->name}")
        ->image(asset('img/invoice.png'))
        ->canonical(route('invoices.show', $invoice))
        ->noindex();
}
