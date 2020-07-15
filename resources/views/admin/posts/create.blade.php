@extends('layouts.dashboard')

@section('content')
  <div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
      <h1>Write new post</h1>
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
    <form action="{{route('admin.posts.store')}}" method="post">
      @csrf
      <div class="form-group mt-3">
        <label for="post-title">Title</label>
        <input type="text" class="form-control" id="post-title" name="title" placeholder="Engaging title" value="{{old('title')}} ">
      </div>
      <div class="form-group">
        <label for="post-content">Content</label>
        <input type="textarea" class="form-control" id="post-content" name="content" placeholder="Inspiring post" value="{{old('content')}} ">
      </div>
      <div class="form-group">
        <label for="post-category">Category</label>
        <select id="post-category" name="category_id">
          <option value="-1">Choose category</option>
          @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
        </select>
        <div class="form-group">
          <label for="post-tags">Tags</label>
          @foreach ($tags as $tag)
            <input type="checkbox" name="" id="post-tags" value="">
            <label for="post-tags">Tags</label>
          @endforeach
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Save</a>
    </form>
    
  </div>
@endsection 