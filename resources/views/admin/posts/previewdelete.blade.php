@extends('layouts.dashboard')

@section('content')

  <div class="container mt-3">
    <h1>You are about to <span class="text-warning">delete</span> this Post</h1>
    <h3>{{$post->title}}</h3>
    <p>{{$post->content}}</p>
    <p><small>Slug: {{$post->slug}}</small></p>
    <p><small>Category: {{$post->category->name ?? '-'}}</small></p>
  </div>
  <form action="{{route('admin.posts.destroy', ['post' => $post->id])}}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
  </form>
    
@endsection