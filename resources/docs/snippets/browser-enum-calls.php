OrderStatus::Shipped->label();        // "On its way"
OrderStatus::from('packed');          // OrderStatus::Packed
OrderStatus::tryFrom('lost');         // null
count(OrderStatus::cases());          // 4
$status === OrderStatus::Delivered;   // compared as in PHP
