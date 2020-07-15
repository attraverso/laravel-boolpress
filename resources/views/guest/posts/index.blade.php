@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h1>All posts</h1>
        </div>
        <div>
          <ul>
            @forelse ($posts as $post)
                <li>
                  <a href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a>
                </li>
            @empty
                <li>There's nothing here...</li>
            @endforelse
          </ul>
        </div>  
      </div>
    </div>
  </div>
@endsection