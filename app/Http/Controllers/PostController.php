<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
  public function index() {
    $posts = Post::all();
    return view('guest.posts.index', compact('posts'));
  }

  public function show($id) {
    $post = Post::find($id);
    if ($post) {
       return view('guest.posts.show', compact('post'));
    } else {
      return abort('404');
    }
  }
}
