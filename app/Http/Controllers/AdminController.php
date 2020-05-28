<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin', compact('services')); 
    }
}
