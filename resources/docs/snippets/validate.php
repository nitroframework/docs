#[Validate('integer|min:1|max:10', as: 'quantity')]
public int $quantity = 1;

#[Server]
public function checkout(): void
{
    // $quantity is between 1 and 10 here
}
