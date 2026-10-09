public function fallback(): string
{
    return 'The balance is not available right now.';   // Text: escaped.
}

public function fallback(): View
{
    return view('partials.bank-unavailable');          // A view: rendered.
}

public function fallback(): HtmlString
{
    return new HtmlString('<p class="muted">Unavailable</p>');   // Htmlable: as it is.
}
