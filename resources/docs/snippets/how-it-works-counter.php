class Counter extends Component
{
    public int $count = 0;

    /** Runs in the browser: compiled to JavaScript. */
    public function increment(): void
    {
        $this->count++;
    }

    /** Runs on the server: never compiled. */
    #[Server]
    public function save(): void
    {
        Score::create(['value' => $this->count]);
    }
}
