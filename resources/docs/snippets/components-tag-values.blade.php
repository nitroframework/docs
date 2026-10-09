{{-- resources/views/nitro/components/order.blade.php --}}
<div>
    <nitro:order-line
        label="Gift wrap"
        :quantity="$quantity"
        :unit-price="$product->price_cents"
        :editable="! $locked"
    />
</div>
