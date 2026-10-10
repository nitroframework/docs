<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/** robots.txt: everything may be crawled, and where the sitemap is (on whichever domain serves the site). */
class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        return response("User-agent: *\nDisallow: /demo/\n\nSitemap: ".url('/sitemap.xml')."\n", 200, ['Content-Type' => 'text/plain']);
    }
}
