<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Source\Source;
use Illuminate\Http\JsonResponse;

class SourceController extends Controller
{
    public function getGameSources(): JsonResponse
    {
        return response()->json(Source::query()->paginate());
    }
}
