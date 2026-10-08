/* <php>
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
</php> */

import { Show } from 'solid-js';

export default function Newsletter(props) {
    return (
        <Show when={!props.done} fallback={<p>Thanks: you're on the list.</p>}>
            <form onSubmit={(e) => (e.preventDefault(), props.subscribe())}>
                <input type="email" value={props.email} onInput={(e) => props.set('email', e.currentTarget.value)} />
                <button disabled={props.subscribe.processing}>Subscribe</button>
                <Show when={props.errors.email}><p class="error">{props.errors.email[0]}</p></Show>
            </form>
        </Show>
    );
}
