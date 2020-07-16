<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
use App\Tag;

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
    $categories = Category::all();
    $tags = Tag::all();
    return view('admin.posts.create', compact('categories', 'tags'));
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
    /* $request initializes $data with an ARRAY? //FIXME find out!*/
    $data = $request->all();
    $slug = Str::of($data['title'])->slug('-');
    $rawSlug = $slug;
    $postFound = Post::where('slug', $slug)->first();
    $counter = 0;
    while ($postFound) {
      $counter++;
      $slug = $rawSlug . '-' . $counter;
      $postFound = Post::where('slug', $slug)->first();
    }
    $data['slug'] = $slug;
    // dd($data);
    $newPost = new Post();
    /* You can use fill() to populate a Model's properties, which means a table's columns */
    $newPost->fill($data);
    $newPost->save();
    // You can't use fill() for tags as they're not on the Post Model / posts table
    // Check whether tag_ids exists, since if no checkboxes were selected, you won't get any 'tag_ids' key in $data, not even with an empty array
    if (!empty($data['tag_ids'])) {
      // TODO check whether the ids in tag_ids are valid or maliciously sent via html manipulation (0715_0128)
      // Ferry the tag_ids array you initialized in $data from $request directly into sync()
     $newPost->tags()->sync($data['tag_ids']);
    }
    return redirect()->route('admin.posts.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $post = Post::find($id);
    if ($post) {
      /** You don't care about prettifiying the url, since crawlers don't have access to pw-protected spaces */
       return view('admin.posts.show', compact('post'));
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
    $tags = Tag::all();
    $categories = Category::all();
    return view('admin.posts.edit', compact('post', 'categories', 'tags'));
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
      'title' => 'required|max:255|unique:posts,title,'.$id,
      'content' => 'required'
    ]);
    /* $request initializes $data with an array */
    $data = $request->all();
    $slug = Str::of($data['title'])->slug('-');
    $rawSlug = $slug;
    $postFound = Post::where('slug', $slug)->first();
    $counter = 0;
    while ($postFound) {
      $counter++;
      $slug = $rawSlug . '-' . $counter;
      $postFound = Post::where('slug', $slug)->first();
    }
    $data['slug'] = $slug;
    $post = Post::find($id);
    $post->update($data);
    if (!empty($data['tag_ids'])) {
      // TODO check whether the ids in tag_ids are valid or maliciously sent via html manipulation (0715_0128)
      // Ferry the tag_ids array you initialized in $data from $request directly into sync()
     $post->tags()->sync($data['tag_ids']);
    }
    return redirect()->route('admin.posts.index');
  }

  public function previewdelete($id)
  {
    $post = Post::find($id);
    /** You don't care about prettifiying the url, since crawlers don't have access to pw-protected spaces */
    return view('admin.posts.previewdelete', compact('post'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    $post->tags()->sync([]);
    $post->delete();
    return redirect()->route('admin.posts.index');
  }
}
