use App\Nitro\Attributes\Throttle;

#[Server]
#[Throttle(perMinute: 3)]
public function send(): void
{
    Mail::to($this->email)->send(new ContactMessage($this->message));
}
