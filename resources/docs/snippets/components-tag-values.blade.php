{{-- resources/views/fusion/components/order.blade.php --}}
<div>
    <fusion:order-line
        label="Gift wrap"
        :quantity="$quantity"
        :unit-price="$product->price_cents"
        :editable="! $locked"
    />
</div>
