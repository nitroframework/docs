<?php

namespace App\Http\Controllers;

use App\Docs\SearchIndex;
use Illuminate\Http\JsonResponse;

/** The search index ⌘K fetches the first time it opens. */
class SearchIndexController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(SearchIndex::get())->header('Cache-Control', 'no-cache');
    }
}
