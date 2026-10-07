use Nitro\Fusion\Testing\AssertableFusion;

public function test_the_report_loads_its_stats_after_it_shows(): void
{
    // The page as it first arrives: the stats come later.
    $this->get('/report')->assertFusion(fn (AssertableFusion $page) => $page
        ->deferred('stats'));

    // A fusion:navigate visit: the page's data instead of its HTML.
    $this->withHeaders(['X-Fusion-Navigate' => '1', 'Accept' => 'application/json'])
        ->get('/report')
        ->assertFusion(fn (AssertableFusion $page) => $page->page('pages::report'));

    // The browser's next request: the stats themselves (a partial reload).
    $this->withHeaders([
        'X-Fusion-Navigate' => '1',
        'X-Fusion-Partial' => 'fabcdefghij',   // the page's id in the browser
        'X-Fusion-Only' => 'stats',
        'Accept' => 'application/json',
    ])->get('/report')->assertFusion(fn (AssertableFusion $page) => $page
        ->notDeferred()
        ->has('stats.orders'));
}
