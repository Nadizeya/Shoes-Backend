<?php

namespace App\Http\Controllers\admin\home;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class HomePageController extends Controller
{
    public function index(Request $request)
    {

        return view('welcome');
    }
    public function check(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Redirect to the home page or another page for authenticated users
            return redirect()->route('home');
        }

        // Redirect to the login page if the user is not authenticated
        return redirect()->route('admin.login');
    }
}
