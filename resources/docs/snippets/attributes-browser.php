use Nitro\Attributes\Browser;

#[Browser]                                  // its static methods run in the browser too
final class Money
{
    public static function format(int $cents): string
    {
        return '$'.number_format($cents / 100, 2);
    }
}
