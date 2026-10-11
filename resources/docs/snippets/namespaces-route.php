// modules/Billing/routes/web.php
use Billing\Ui\Pages\Invoices;

Route::nitro('/invoices', Invoices\Index::class);
Route::nitro('/invoices/{invoice}', Invoices\Show::class);
