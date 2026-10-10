<?php

namespace App\Http\Controllers;

use App\Docs\Nav;
use Illuminate\Http\Response;

/** sitemap.xml: the home page and every written docs page, for search engines. */
class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [['loc' => url('/'), 'lastmod' => filemtime(resource_path('views/home.blade.php'))]];

        foreach (array_keys(Nav::pages()) as $slug) {
            $file = resource_path("views/docs/content/{$slug}.blade.php");

            if (is_file($file)) {
                $urls[] = ['loc' => url("/docs/{$slug}"), 'lastmod' => filemtime($file)];
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= '  <url><loc>'.e($url['loc']).'</loc><lastmod>'.date('Y-m-d', $url['lastmod']).'</lastmod></url>'."\n";
        }

        return response($xml.'</urlset>'."\n", 200, ['Content-Type' => 'application/xml']);
    }
}
