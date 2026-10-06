<?php

use App\Fusion\Pages\Docs\Show;
use App\Http\Controllers\SearchIndexController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

/** Islands only exist in a plain Blade view: the Islands page's demo. */
Route::view('/demo/islands', 'demo.islands');

/** What ⌘K searches (App\Docs\SearchIndex). */
Route::get('/docs/search.json', SearchIndexController::class);

/** The docs: one Fusion page per sidebar entry (config/docs.php); the ones not written yet show a placeholder. */
Route::redirect('/docs', '/docs/introduction');
Route::fusion('/docs/{page}', Show::class)->where('page', '[a-z0-9-]+');
