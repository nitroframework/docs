class InvoicePanel extends Component
{
    public int $invoiceId;            // Sent to the browser.
    #[Locked] public string $status;  // Sent, but can't be changed.

    #[Server]
    public function send(): void
    {
        // Load the invoice where you need it, not in the state.
        $invoice = Invoice::findOrFail($this->invoiceId);

        Mail::to($invoice->customer->email)->send(new InvoiceMail($invoice));
    }
}
