<?php

namespace App\Http\Controllers;

use App\User;
use App\Service;
use App\Category;
use App\Mail\InviteManager;
use Illuminate\Http\Request;
use App\Mail\InviteManagerEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->get();
        return view('admin.services', compact('services')); 
    }

    public function getServices(Request $request)
    {
        $services = Service::all();
        return response()->json(['success' => true, 'services' => $services]);
    }

    public function serviceCategories(Request $request)
    {
        $categories = Category::all();
        return response()->json(['success' => true, 'categories' => $categories]);
    }

    public function addService(Request $request)
    {
        $request->validate([
            'category_id' => ['required','numeric'],
            'name' => ['required'],
            'periodindays' => ['required','numeric'],
            'price' => ['required','numeric'],
            'likes' => ['required','numeric'],
            'posts' => ['required'],
            'views' => ['required','numeric'],
        ]);

        Service::updateOrCreate(['id' => $request->id], [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'periodindays' => $request->periodindays,
            'price' => $request->price,
            'likes' => $request->likes,
            'posts' => $request->posts,
            'views' => $request->views,
            'bonus' => $request->bonus,
            'igtv_unlim' => $request->igtv_unlim,
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteService(Request $request)
    {
        Service::destroy($request->id);
        return response()->json(['success' => true]);
    }




    public function managers(Request $request)
    {

        if($request->ajax()) {

            /**
             * Delete manager
             */
            if($request->filled('action') && $request->action == 'delete') {
                User::find($request->id)->delete();
    
                return response(['success' => true]);
            }


            /**
             * Invite manager
             */
            if($request->filled('action') && $request->action == 'invite') {
                $user = User::create([
                    'email' => $request->email,
                    'full_name' => 'Invited Manager',
                    'password' => Hash::make('some string'),
                    'usertype' => User::USERTYPE_MANAGER,
                ]);
    
                Mail::to($request->email)->send( new InviteManager($user->id, $request->email) );
    
                return $user;
            }



            /**
             * Get manager clients
             */
            if($request->filled('action') && $request->action == 'getmanagerclients') {
                $clients = User::where('manager', $request->idmanager)->withCount('orders')->get();
    
                return response()->json(['success' => true, 'clients' => $clients]);
            }
        }



        $managers = User::where('usertype', USER::USERTYPE_MANAGER)->withCount('clients')->get();

        return view('admin.managers', ['items' => $managers]);
    }

}
