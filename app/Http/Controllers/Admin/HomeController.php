<?php

/** this namespace will host all the controllers that manage the admin dashboard */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index() {  
    return view('admin.home');
  }
}
