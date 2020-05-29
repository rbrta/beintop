<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $services = Service::all();
        // return view('client', compact('services')); 
        return "UserController@index";
    }
}
