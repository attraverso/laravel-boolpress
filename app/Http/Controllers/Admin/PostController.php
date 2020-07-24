<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Category;
use App\Tag;
use App\PostTag;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    /** $posts is initialized with a collection */
    $posts = Post::with('category')->get();
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
  /** dependency injection: telling PHP that the parameter in the function MUST be an object of type Request */
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|max:255|unique:posts,title',
      'content' => 'required'
    ]);
    /* $request initializes $data with an ARRAY of all the values I got from the form*/
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
    $newPost = new Post();
    /* You can use fill() to populate a Model's properties, which means a table's columns */
    $newPost->fill($data);
    $newPost->save();
    // You can't use fill() for tags as they're not on the Post Model / posts table
    // Check whether tag_ids exists, since if no checkboxes were selected, you wouldn't get any 'tag_ids' key in $data, not even with an empty array as value
    if (!empty($data['tag_ids'])) {
      // TODO check whether the ids in tag_ids are valid tags that are already stored in my db or maliciously sent via html manipulation (0715_0228 -> where tag id in table? find tag?)
      // Ferry the tag_ids array you get in $data (from $request->all()) directly into sync()
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
    /** $post is initialized with a single Post object */
    $post = Post::find($id);
    $pts = PostTag::all();
    $ptmatches_store = [];
    foreach ($pts as $pt) {
       $ptmatch = $pt->post_id . '-' . $pt->tag_id;
       array_push($ptmatches_store, $ptmatch);
    }
    // dd($ptmatches_store);

    /** check whether the post actually exists -> in case people tamper with the URLs */
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
    /** check whether the post actually exists -> in case people tamper with the URLs */
    /** $post is initialized with an object of type Post */
    $post = Post::find($id);
    if ($post) {
       // alternative to compact to ferry data:
      $data = [
        'post' => $post,
        'tags' => Tag::all(),
        'categories' => Category::all(),
      ];
      return view('admin.posts.edit', $data);
    } else {
      return abort('404');
    }
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
    $data = $request->all(); //OK
    $post = Post::find($id);
    $newSlug = Str::of($data['title'])->slug('-'); /* //FIXME: check wth is happening here <- */
    $rawSlug = $newSlug;
    $postFound = Post::where('slug', $newSlug)->first();
    $counter = 0;
    while ($postFound && $post->id != $postFound->id) {
      
      $counter++;
      $slug = $rawSlug . '-' . $counter;
      $postFound = Post::where('slug', $slug)->first();
      $data['slug'] = $slug;
    }
    $post->update($data);
    // Check whether tag_ids exists because, if no checkboxes were selected, you wouldn't get any 'tag_ids' key in $data (not even with an empty array as value) so this wouldn't delete any existing post->tag relationship in the post_tag table
    if (!empty($data['tag_ids'])) {
      // TODO check whether the ids in tag_ids are valid or maliciously sent via html manipulation (0715_0128)
      // Ferry the tag_ids array you initialized in $data from $request directly into sync()
     $post->tags()->sync($data['tag_ids']);
    //in case the user has deselected all tags, remove any post/tag association
    } else {
      // either one or the other is fine:
      // $post->tags()->detach();
      $post->tags()->sync([]);
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
