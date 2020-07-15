@extends('layouts.app')

@section('content')
<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center">
  <h1>Showing posts by category: {{$category->name}}</h1>
    <div>  
      <a href="{{route('categories.index')}}" class="btn btn-secondary">All categories</a>
      {{-- // TODO check whether you can link this <a href="{{route('admin.categories.index')}}" class="btn btn-secondary" disabled>Back to post</a>--}}
    </div>
  </div>
  <div class=" p-2 border border-secondary">
    <ul class="list-group">
    @forelse ($posts as $post)
      <li class="list-group-item"><a href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a></li>
    @empty
      <li class="list-group-item">There's nothing here...</li>
    @endforelse
    </ul>
  </div>
</div>
@endsection