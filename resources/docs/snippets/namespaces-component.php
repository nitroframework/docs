// modules/Billing/Ui/Components/InvoiceTable.php
namespace Billing\Ui\Components;

use Billing\Contracts\Invoices;
use Nitro\Attributes\Server;
use Nitro\Component;

class InvoiceTable extends Component
{
    public array $invoices = [];

    public function mount(Invoices $invoices): void
    {
        $this->invoices = $invoices->open();
    }

    #[Server]
    public function markPaid(int $id, Invoices $invoices): void
    {
        $invoices->markPaid($id);
        $this->invoices = $invoices->open();
    }
}
