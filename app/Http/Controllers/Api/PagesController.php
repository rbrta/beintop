<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function services(): JsonResponse
    {
        $services = Service::with("category")->get()->groupBy('category.name');

        return response()->json($services);
    }
}
