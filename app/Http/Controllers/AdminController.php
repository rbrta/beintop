<?php

namespace App\Http\Controllers;

use App\Service;
use App\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin', compact('services')); 
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
            'bonus_comments' => ['required'],
            'bonus_posts' => ['required','numeric'],
        ]);

        Service::updateOrCreate(['id' => $request->id], [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'periodindays' => $request->periodindays,
            'price' => $request->price,
            'likes' => $request->likes,
            'posts' => $request->posts,
            'views' => $request->views,
            'bonus_comments' => $request->bonus_comments,
            'bonus_posts' => $request->bonus_posts,
            'igtv_unlim' => $request->igtv_unlim,
        ]);

        return response()->json(['success' => true]);
    }
}
