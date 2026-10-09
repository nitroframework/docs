use Nitro\Testing\AssertableNitro;

public function test_the_report_loads_its_stats_after_it_shows(): void
{
    // The page as it first arrives: the stats come later.
    $this->get('/report')->assertNitro(fn (AssertableNitro $page) => $page
        ->deferred('stats'));

    // A nitro:navigate visit: the page's data instead of its HTML.
    $this->withHeaders(['X-Nitro-Navigate' => '1', 'Accept' => 'application/json'])
        ->get('/report')
        ->assertNitro(fn (AssertableNitro $page) => $page->page('pages::report'));

    // The browser's next request: the stats themselves (a partial reload).
    $this->withHeaders([
        'X-Nitro-Navigate' => '1',
        'X-Nitro-Partial' => 'fabcdefghij',   // the page's id in the browser
        'X-Nitro-Only' => 'stats',
        'Accept' => 'application/json',
    ])->get('/report')->assertNitro(fn (AssertableNitro $page) => $page
        ->notDeferred()
        ->has('stats.orders'));
}
