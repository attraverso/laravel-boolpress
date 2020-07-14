<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        /** in case there's no records in the databast, posts contains an empty collection */
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'title' => 'required|max:255|unique:posts,title',
        'content' => 'required'
      ]);
      /* $request initializes $data with an array */
      $data = $request->all();
      $slug = Str::of($data['title'])->slug('-');
      $data['slug'] = $slug; 
      var_dump($data);
      $newPost = new Post();
      $newPost->fill($data);
      $newPost->save();
      return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
      if ($post) {
        /** You don't care about prettifiying the url, since crawlers don't have access to pw-protected spaces */
        return view('admin.posts.show', ['posts', $post->id]);
      } else {
        return abort('404');
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $post = Post::find($id);
      return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'title' => 'required|max:255|unique:posts,title'.$id,
        'content' => 'required'
      ]);
      /* $request initializes $data with an array */
      $data = $request->all();
      $slug = Str::of($data['title'])->slug('-');
      $data['slug'] = $slug;
      $post = Post::find($id);
      $post->update($data);
      $post->save();
      return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::find($id);
      $post->delete();
    }
}
