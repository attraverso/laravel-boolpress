@extends('layouts.dashboard')

@section('content')

  <div class="container mt-3">
    <h1>You are about to <span class="text-danger">delete</span> this Post</h1>
    <h3>Title: {{$post->title}}</h3>
    <p class="bg-white">{{$post->content}}</p>
    <p><small>Slug: {{$post->slug}}</small></p>
    <p><small>Category: {{$post->category->name ?? '-'}}</small></p>
    <form action="{{route('admin.posts.destroy', ['post' => $post->id])}}" method="post">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger" type="submit">Delete</button>
    </form>
  </div>
  
    
@endsection