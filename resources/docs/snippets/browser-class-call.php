use App\Support\Money;

public function label(): string
{
    return Money::format($this->total);
}
