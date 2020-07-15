@extends('layouts.dashboard')

@section('content')

  <div class="container mt-3">
    <h1>Your post</h1>
    <h2>{{$post->title}}</h2>
    <p>{{$post->content}}</p>
    <p><small>Slug: {{$post->slug}}</small></p>
    <p><small>Category: {{$post->category->name ?? '-'}}</small></p>
  </div>
    
@endsection