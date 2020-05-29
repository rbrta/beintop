<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $services = Service::with(["category"])->get();
        // return $services;
        // return view('homepage', compact('services')); 
    }
}
