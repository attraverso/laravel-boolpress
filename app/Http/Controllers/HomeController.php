<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *  
     * @return void
     */
    
    /**** this use of the commented constructor below would make it so that if you want to use this * whole controller and its routes, you need to be logged in.
    *
    * Since this makes things harder in the long run, we're going to use the middleware directly * on the routes instead. Kepping the code for reference ****/

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function e404() {
        return view('404');
    }
}
 