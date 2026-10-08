<php>
use App\Models\Subscriber;

new class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    public bool $done = false;

    #[Server]
    public function subscribe(): void
    {
        $this->validate();
        Subscriber::firstOrCreate(['email' => $this->email]);
        $this->done = true;
    }
};
</php>

<script>
    let { email = $bindable(), done, subscribe, errors } = $props();
</script>

{#if done}
    <p>Thanks: you're on the list.</p>
{:else}
    <form onsubmit={(e) => (e.preventDefault(), subscribe())}>
        <input type="email" bind:value={email} placeholder="you@example.com">
        <button disabled={subscribe.processing}>Subscribe</button>
        {#if errors.email}<p class="error">{errors.email[0]}</p>{/if}
    </form>
{/if}
