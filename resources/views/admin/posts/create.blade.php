@extends('layouts.dashboard')

@section('content')
  <div class="container mt-3">
    <h1>Write new post</h1>
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
      <button type="submit" class="btn btn-primary">Save</a>
    </form>
    
  </div>
@endsection 