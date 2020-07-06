<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, $idservice = null, $idmanager = null)
    {
        if($idmanager !== null) {
            session(['idmanager' => $idmanager, 'idservice' => $idservice]);

            if($request->cookie('isuser', false)) {
                return redirect('/userpanel/show_'.$idservice);
            }
        }

        $services = Service::with("category")->get()->groupBy('category.name');
        return view('homepage', ['services' => $services, 'idService' => $idservice]); 
    }

    public function getService($id = null)
    {
        if($id == null) {
            return false;
        }

        return Service::with('category')->where('id', $id)->first();
    }

    
}
