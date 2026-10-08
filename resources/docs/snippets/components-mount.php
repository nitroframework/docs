<?php

namespace App\Fusion\Components;

use App\Models\Invoice;
use App\Services\Currency;
use Nitro\Fusion\Attributes\Locked;
use Nitro\Fusion\Component;

class InvoiceSummary extends Component
{
    #[Locked]
    public int $invoiceId;

    public string $total = '';

    public array $lines = [];

    /**
     * Runs once, on the server: the tag's values by name (:invoice="$invoice"), and anything else
     * Laravel's container can give, as in a controller.
     */
    public function mount(Invoice $invoice, Currency $currency): void
    {
        $this->invoiceId = $invoice->id;
        $this->total = $currency->format($invoice->total_cents, $invoice->currency);
        $this->lines = $invoice->lines()->get(['description', 'quantity', 'amount_cents'])->toArray();
    }
}
