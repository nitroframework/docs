<?php

use App\Nitro\Pages\Articles\Index as BlogIndex;
use App\Nitro\Pages\Articles\Show as BlogPost;
use App\Nitro\Pages\Demo\ReactPage;
use App\Nitro\Pages\Demo\SolidPage;
use App\Nitro\Pages\Demo\SveltePage;
use App\Nitro\Pages\Demo\VuePage;
use App\Nitro\Pages\Docs\Show;
use App\Http\Controllers\CompiledController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SearchIndexController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

/** For search engines: every page (App\Docs\Nav), and where that list is. */
Route::get('/sitemap.xml', SitemapController::class);
Route::get('/robots.txt', RobotsController::class);

/** Islands only exist in a plain Blade view: the Islands page's demo. */
Route::view('/demo/islands', 'demo.islands');

/** Pages whose whole view is Vue, React, Solid or Svelte: each framework's page links to its own. */
Route::nitro('/demo/vue', VuePage::class);
Route::nitro('/demo/react', ReactPage::class);
Route::nitro('/demo/solid', SolidPage::class);
Route::nitro('/demo/svelte', SveltePage::class);

/** A component's compiled JavaScript, for a "Compiled" panel as it opens (App\Docs\Code::compiled()). */
Route::get('/docs/compiled/{component}', CompiledController::class)->where('component', '[a-z0-9:.-]+');

/** What ⌘K searches (App\Docs\SearchIndex). */
Route::get('/docs/search.json', SearchIndexController::class);

/** The blog: one Nitro page per post (resources/articles, App\Articles\Articles), and its RSS feed. */
Route::nitro('/blog', BlogIndex::class);
Route::get('/blog/feed.xml', FeedController::class);
Route::nitro('/blog/{slug}', BlogPost::class)->where('slug', '[a-z0-9-]+');

/** The docs: one Nitro page per sidebar entry (config/docs.php); the ones not written yet show a placeholder. */
Route::redirect('/docs', '/docs/introduction');
Route::nitro('/docs/{page}', Show::class)->where('page', '[a-z0-9-]+');
