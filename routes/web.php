<?php

use App\Nitro\Pages\Docs\Show;
use App\Http\Controllers\CompiledController;
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

/** A component's compiled JavaScript, for a "Compiled" panel as it opens (App\Docs\Code::compiled()). */
Route::get('/docs/compiled/{component}', CompiledController::class)->where('component', '[a-z0-9:.-]+');

/** What ⌘K searches (App\Docs\SearchIndex). */
Route::get('/docs/search.json', SearchIndexController::class);

/** The docs: one Nitro page per sidebar entry (config/docs.php); the ones not written yet show a placeholder. */
Route::redirect('/docs', '/docs/introduction');
Route::nitro('/docs/{page}', Show::class)->where('page', '[a-z0-9-]+');
