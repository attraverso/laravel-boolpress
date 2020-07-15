@extends('layouts.app')

@section('content')
<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center">
    <h1>{{$post->title}}</h1>
    <a href="{{route('posts.index')}}" class="btn btn-secondary">Back to list</a>
  </div>
  <div class=" p-2 border border-secondary">
    <p>{{$post->content}}</p>
    <p><small>Category: {{$post->category->name ?? '-'}}</small></p>
  </div>
</div>
@endsection