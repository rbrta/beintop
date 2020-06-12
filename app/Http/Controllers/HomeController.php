<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($idservice = null)
    {

        $idService = $idservice == null ? $idservice : str_replace('buy_service_', '', $idservice);

        $services = Service::with("category")->get()->groupBy('category.name');
        return view('homepage', ['services' => $services, 'idService' => $idService]); 
    }

    public function getService($id = null)
    {
        if($id == null) {
            return false;
        }

        return Service::with('category')->where('id', $id)->first();
    }
}
