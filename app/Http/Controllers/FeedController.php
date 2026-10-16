<?php

namespace App\Http\Controllers;

use App\Articles\Articles;
use Carbon\CarbonImmutable;
use Illuminate\Http\Response;

/** The blog's RSS feed: every post, newest first (App\Articles\Articles). */
class FeedController extends Controller
{
    public function __invoke(): Response
    {
        $articles = Articles::all();
        $date = fn (string $day) => CarbonImmutable::parse($day)->toRssString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'."\n"
            .'<channel>'."\n"
            .'  <title>Nitro blog</title>'."\n"
            .'  <link>'.e(url('/blog')).'</link>'."\n"
            .'  <description>Releases, guides and how Nitro works inside.</description>'."\n"
            .'  <language>en</language>'."\n"
            .'  <atom:link href="'.e(url('/blog/feed.xml')).'" rel="self" type="application/rss+xml"/>'."\n";

        if ($articles !== []) {
            $xml .= '  <lastBuildDate>'.$date($articles[0]['date']).'</lastBuildDate>'."\n";
        }

        foreach ($articles as $article) {
            $link = e(url(Articles::url($article['slug'])));
            $xml .= '  <item>'."\n"
                .'    <title>'.e($article['title']).'</title>'."\n"
                .'    <link>'.$link.'</link>'."\n"
                .'    <guid isPermaLink="true">'.$link.'</guid>'."\n"
                .'    <description>'.e($article['description']).'</description>'."\n"
                .'    <pubDate>'.$date($article['date']).'</pubDate>'."\n"
                .'  </item>'."\n";
        }

        return response($xml.'</channel>'."\n".'</rss>'."\n", 200, ['Content-Type' => 'application/rss+xml; charset=UTF-8']);
    }
}
