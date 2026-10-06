/* <php>
use App\Models\Invitation;
use Illuminate\Support\Str;

new class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    #[Computed]
    public function domain(): string
    {
        return Str::after($this->email, '@');
    }

    #[Server]
    public function invite(): void
    {
        $this->validate();
        Invitation::send($this->email, invitedBy: auth()->user());
    }
};
</php> */

export default function InviteForm({ email, domain, set, invite, errors }) {
    return (
        <div className="invite">
            <input value={email} onChange={(e) => set('email', e.target.value)} />
            {domain && <small>@{domain}</small>}
            {errors.email && <p className="error">{errors.email[0]}</p>}
            <button disabled={invite.processing} onClick={() => invite()}>Invite</button>
        </div>
    );
}
