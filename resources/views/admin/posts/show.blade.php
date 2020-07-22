@extends('layouts.dashboard')

@section('content')

  <div class="container mt-3">
    
    <div class="d-flex justify-content-between align-items-center">
      <h1>Your post</h1>
      <a href="{{route('admin.posts.index')}}" class="btn btn-secondary">Back to list</a>
    </div>
    <div class=" p-2 border border-secondary">
      <h2>Title: {{$post->title}}</h2>
      <p>{{$post->content}}</p>
      <p><small>Slug: {{$post->slug}}</small></p>
      <p><small>Category: {{$post->category->name ?? '-'}}</small></p>
      <p><small>Tags:
        @forelse ($post->tags as $tag)
          {{$tag->name}}{{ $loop->last ? '' : ','}}
        @empty
          -
        @endforelse
      </small></p>
      {{-- Invoke a function that automatically combines properties together (see Post model) --}}
      <p><small>Title/slug comparison:<br>
        {{$post->compareTitleSlug()}}
      </small></p>
    </div>
  </div>
    
@endsection