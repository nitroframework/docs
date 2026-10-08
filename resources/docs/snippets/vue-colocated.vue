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

<template>
    <p v-if="done">Thanks: you're on the list.</p>
    <form v-else @submit.prevent="subscribe">
        <input v-model="email" type="email" placeholder="you@example.com">
        <button :disabled="subscribe.processing">Subscribe</button>
        <p v-if="errors.email" class="error">{{ errors.email[0] }}</p>
    </form>
</template>
