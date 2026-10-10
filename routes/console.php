<?php

use App\Docs\SearchIndex;
use Illuminate\Support\Facades\Artisan;

Artisan::command('docs:index', function () {
    $started = microtime(true);
    $entries = count(SearchIndex::get());
    $this->info(sprintf('Search index: %d sections, the pages\' code highlighted, in %.1fs.', $entries, microtime(true) - $started));
})->purpose('Build the search index, highlighting every page\'s code on the way (run it when deploying)');
