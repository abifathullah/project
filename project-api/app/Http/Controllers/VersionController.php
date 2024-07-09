<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class VersionController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getVersions(): JsonResponse
    {
        return response()->json([
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
        ], 200);
    }
}
