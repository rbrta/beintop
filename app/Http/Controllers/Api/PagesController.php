<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Category;
use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function services(Request $request): JsonResponse
    {
        if($request->isMethod('delete')) {
            $request->validate([
                'id' => 'required'
            ]);

            Service::destroy($request->get('id'));

            return response()->json([
                'success' => true
            ]);
        }

        /**
         *
         */
        if($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'periodindays' => 'required',
                'price' => 'required',
                'likes' => 'required',
                'posts' => 'required',
                'views' => 'required',
                'igtv_unlim' => 'required',
                'category_id' => 'required',
            ]);

            $tariff = Service::updateOrCreate([
                'id' => $request->get('id'),
            ], [
                'name' => $request->get('name'),
                'periodindays' => $request->get('periodindays'),
                'price' => $request->get('price'),
                'likes' => $request->get('likes'),
                'posts' => $request->get('posts'),
                'views' => $request->get('views'),
                'igtv_unlim' => $request->get('igtv_unlim'),
                'category_id' => $request->get('category_id'),
            ]);

            return response()->json($tariff->fresh('category'));
        }

        $services = Service::with("category")->get()->groupBy('category.name');

        return response()->json($services);
    }

    /**
     * @return JsonResponse
     */
    public function users(): JsonResponse
    {
        $users = User::where('usertype', 'user')->get();

        return response()->json($users);
    }

    /**
     * @return JsonResponse
     */
    public function categories(): JsonResponse
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function managers(Request $request)
    {
        if($request->isMethod('delete')) {
            $request->validate([
                'id' => 'required',
                'id_new' => 'required'
            ], [
                'id_new.required' => 'Укажите менеджера, которому нужно привязать клиентов'
            ]);

            // move all users to new manager
            $users = User::where('manager', $request->get('id'));

            if($users->count() > 0 ) {
                $users->update(['manager' => $request->get('id_new')]);
            }

            // remove manager
            User::find($request->get('id'))->delete();

            return response()->json(['success' => true]);
        }

        /**
         * Get managers clients
         */
        if($request->exists('id')) {
            $clients = User::where('manager', $request->get('id'))->withCount('orders')->withCount('activeOrders')->get();

            return response()->json($clients);
        }

        $managers = User::where('usertype', USER::USERTYPE_MANAGER)->withCount('clients')->get();

        return response()->json($managers);
    }
}
