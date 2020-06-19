<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    public function index()
    {
        dd('hello, manager');
    }


    public function confirmation($userid = null, $token = null)
    {
        $user = User::where('id', $userid)->first();
        $_token = substr(md5($user->email), 0, 8);

        if($token !== $_token) {
            abort(403, 'Не верный токен');
        }
        
        return view('manager.signup', ['email' => $user->email]);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'full_name' => 'required|min:3',
            'password' => 'required|confirmed|min:6',
        ]);

        if($request->filled('action') && $request->action == 'signup') {
            $userSrc = User::where('email', $request->email);

            $request->merge(['email_verified' => Carbon::now()->format('Y-m-d H:i:s')]);
            $userSrc->update($request->except(['action', 'email', '_token', 'password_confirmation', 'email_verified']));
           
            $user = $userSrc->first();
            Auth::loginUsingId($user->id);

            return redirect('/manager/');
        }
    }
}
