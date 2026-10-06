use App\Enums\OrderStatus;

public OrderStatus $status = OrderStatus::Placed;

public function advance(): void
{
    $this->status = $this->status->next();
}
