<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
// use App\Post;

class CategoryController extends Controller
{
  public function index() {
    $categories = Category::all();
    return view('guest.categories.index', compact('categories'));
  }

  public function show($slug) {
    $category = Category::where('slug', $slug)->first();
    if ($category) {
      $posts = $category->posts;
      return view('guest.categories.show', compact('category', 'posts'));
    } else {
      return view('404');
    }
  }
}
