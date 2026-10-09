use Nitro\Attributes\View;

#[View('shared.address-form')]          // resources/views/shared/address-form.blade.php
class ShippingAddress extends Component { /* ... */ }

#[View(vue: 'billing/address')]         // resources/views/vue/billing/address.vue
class BillingAddress extends Component { /* ... */ }
