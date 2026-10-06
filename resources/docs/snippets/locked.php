class Wallet extends Component
{
    public int $amount = 0;

    #[Locked]
    public int $balance = 100;

    #[Server]
    public function withdraw(): void
    {
        $this->balance -= $this->amount;
    }
}
