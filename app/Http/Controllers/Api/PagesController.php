<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Mail\InviteManager;
use App\Service;
use App\ServiceParameter;
use App\Social;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PagesController extends Controller
{
    /**
     * @throws ValidationException
     * @throws \Exception
     */
    public function socials(Request $request): JsonResponse
    {
        if( $request->isMethod('delete')) {
            $request->validate([
                'id' => 'required'
            ]);

            $social = Social::with(['services'])->findOrFail((int) $request->get('id'));

            if ($social->services->isNotEmpty()) {
                throw ValidationException::withMessages([
                    'message' => 'Сначала нужно удалить все услуги с этой соц. сетью!'
                ]);
            }

            $social->delete();

            return response()->json([
                'success' => true
            ]);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'code' => 'required'
            ]);

            $social = Social::updateOrCreate([
                'id' => $request->get('id'),
            ], [
                'name' => $request->get('name'),
                'code' => $request->get('code')
            ]);

            return response()->json($social->toArray());
        }

        $query = Social::query()->with(['services']);

        $code = $request->get('code');

        if ($code) {
            $query->where('code', '=',  $code);
        }

        return response()->json($query->get());
    }

    public function socialsOnly(): JsonResponse
    {
        return response()->json(Social::all());
    }
    /**
     * @param Request $request
     * @param string $type
     * @return JsonResponse
     */
    public function services(Request $request, $type = null): JsonResponse
    {
        if($request->isMethod('delete')) {
            $request->validate([
                'id' => 'required'
            ]);

            ServiceParameter::where('service_id', $request->get('id'))->delete();
            Service::destroy($request->get('id'));

            return response()->json([
                'success' => true
            ]);
        }

        /**
         *
         */
        if($request->isMethod('post')) {
            $validationParameters = $this->getValidationParametersByType($request->get('type', Service::TYPE_LIKES));

            $request->validate(array_merge([
                'name' => 'required',
                'price' => 'required',
                'type' => 'required',
                'social_id' => 'required'
            ], $validationParameters));

            $service = Service::updateOrCreate([
                'id' => $request->get('id'),
            ], [
                'name' => $request->get('name'),
                'price' => $request->get('price'),
                'periodindays' => $request->get('periodindays', null),
                'category_id' => $request->get('category_id', null),
                'type' => $request->get('type', Service::TYPE_LIKES),
                'social_id' => (int) $request->get('social_id')
            ]);

            // Delete previous parameters
            if($request->filled('id')) {
                ServiceParameter::where('service_id', $request->get('id'))->delete();
            }

            $parameters = $request->get('parameters', []);

            foreach ($parameters as $paramKey => $paramValue) {
                ServiceParameter::create([
                    'service_id' => $service->id,
                    'key' => $paramKey,
                    'value' => is_bool($paramValue) ? ($paramValue ? '1' : '0') : $paramValue
                ]);
            }

            return response()->json($service->fresh('category'));
        }

        $services = Service::query()->with(['social']);
        if($type) {
            $services = $services->where('type', $type);
        }
        $services = $services->orderBy('price')->get();

        return response()->json([
            'services' => $services,
            'categories' => Category::all(['id', 'name']),
            'socials' => Social::all()
        ]);
    }

    public function getValidationParametersByType($type): array
    {
        $parameters = [
            Service::TYPE_LIKES => [
                'periodindays' => 'required',
                'category_id' => 'required',
                'parameters.likes' => 'required',
                'parameters.posts' => 'required',
                'parameters.views' => 'required',
                'parameters.igtv_unlim' => 'required',
            ],
            Service::TYPE_SUBSCRIBERS => [
                'parameters.subscribers' => 'required',
            ]
        ];

        return $parameters[$type];
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function managers(Request $request): JsonResponse
    {
        /**
         * Invite manager
         */
        if($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email'
            ]);

            $user = User::create([
                'email' => $request->get('email'),
                'full_name' => 'Invited Manager',
                'password' => Hash::make('some string'),
                'usertype' => User::USERTYPE_MANAGER,
            ]);

            Mail::to($user->email)->send(new InviteManager($user->id, $user->email));

            return response()->json($user);
        }

        /**
         * Delete manager
         */
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
