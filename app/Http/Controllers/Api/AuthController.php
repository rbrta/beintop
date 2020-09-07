<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        if($request->has('code')) {
            $request->validate([
                'code' => 'required|string',
            ]);

            $user = User::where('login_code', $request->get('code'))->first();

            if(!$user) {
                throw ValidationException::withMessages([
                    'auth' => 'Пользователь с такими данными не найден'
                ]);
            }
        } else {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if(!Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'auth' => 'Пользователь с такими данными не найден'
                ]);
            }

            $user = auth()->user();
        }

        /**
         * @var $user User
         */
        $token = $user->createToken('Laravel Password Grant Client');

        return response()->json([
            'token' => $token->accessToken
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json();
    }
}
