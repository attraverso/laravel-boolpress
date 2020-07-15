@extends('layouts.dashboard')

@section('content')
  <div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
      <h1>Edit post</h1>
      <a href="{{route('admin.posts.index')}}" class="btn btn-secondary">Back to list</a>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="{{route('admin.posts.update', ['post' => $post->id])}}" method="post">
      @csrf
      @method('PUT')
      <div class="form-group mt-3">
        <label for="post-title">Title</label>
        <input type="text" class="form-control" id="post-title" name="title" placeholder="Engaging title" value="{{old('title', $post->title)}} ">
      </div>
      <div class="form-group">
        <label for="post-content">Content</label>
        <textarea class="form-control" id="post-content" name="content" placeholder="Inspiring post">{{old('content', $post->content)}}</textarea>
      </div>
      <div class="form-group">
        <label for="post-category">Content</label>
        <select name="category_id" id="post-category" class="form-control">
          <option value="-1">Choose category</option>
          @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Save</a>
    </form>
    
  </div>
@endsection 