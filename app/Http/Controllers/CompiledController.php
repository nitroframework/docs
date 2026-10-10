<?php

namespace App\Http\Controllers;

use App\Docs\Code;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Blade;

/** A component's compiled JavaScript, highlighted: what a "Compiled" panel shows as it opens. */
class CompiledController extends Controller
{
    public function __invoke(string $component): Response
    {
        $definition = Code::compiled($component) ?? abort(404);

        return response(Blade::render('<x-docs.code :code="$code" lang="js" bare />', ['code' => $definition]));
    }
}
