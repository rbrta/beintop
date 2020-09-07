<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use Carbon\Carbon;
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

    public function orders(Request $request)
    {
        /**
         * @var $user User
         */
        $user = $request->user();
        $relations = ['user', 'service.category', 'account'];
        $now = Carbon::now();

        if($request->get('tab') === 'archive') {
            $orders = $user->archivedOrders()->with($relations)->get();
        } else {
            $orders = $user->activeOrders()->with($relations)->get();
        }

        $orders->each(static function ($item) use ($now) {
            $item->expiration_date = Carbon::parse($item->expiration_date);
            $item->days = $item->expiration_date->diffInDays($now);
            $item->expiration_date_format = $item->expiration_date->translatedFormat("d F Y");
        });

        return response()->json($orders);
    }
}
