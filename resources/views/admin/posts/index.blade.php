@extends('layouts.dashboard')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h1>Tutti i post</h1>
          <a href="{{route('admin.posts.create')}}" class="btn btn-info text-light">Add Post</a>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Slug</th>
              <th>Category</th>
              <th>Tags</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($posts as $post)
              <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->slug}}</td>
                <td>
                  @if ($post->category)
                    <a href="{{route('categories.show', ['category', $post->category->id])}}">{{$post->category->name ?? '-'}}</a>
                  @else
                    -
                  @endif
                </td>
                <td>
                  @forelse ($post->tags as $tag)
                    {{$tag->name}}{{ $loop->last ? '' : ','}}
                  @empty
                    -
                  @endforelse
                </td>
                <td>
                  <a href="{{route('admin.posts.show', ['post' => $post->id])}} " class="btn btn-info text-light">Details</a>
                  <a href="{{route('admin.posts.edit', ['post' => $post->id])}}" class="btn btn-warning">Edit</a>
                  <a href="{{route('admin.posts.previewdelete', ['post' => $post->id])}}" class="btn btn-danger">Delete</a>
                </td>
              </tr>
            @empty {{-- in case there's no records, $posts contains an empty collection --}}
              <tr>
                <td class="colspan-4">There's nothing here...</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection