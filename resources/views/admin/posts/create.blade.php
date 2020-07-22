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
          <option value="">Choose category</option>
          @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <p>Tags</p>
        @foreach ($tags as $tag)
          <label class="form-check-label mr-1" for="post-tags">
            {{-- the values of all the selected options get written into the tag_ids array.
              * If you'd used tag_ids without [], only the value of the last marked checkbox would've been saved
              ** In case of errors you need to display again any values that had previously been checked. Use in_array to see whether the current tag ID was among those values, and provide a old() with a default value of empty array as alternative case old() isn't storing any actual old values, as in_array can't accept null as a second argument.
              //FIXME clicking on any label will only ever mark the first checkbox --}}
              <input type="checkbox" name="{{--*--}}{{'tag_ids[]'}}" id="post-tags" value="{{$tag->id}}" {{--**--}}{{in_array($tag->id, old('tag_ids', [])) ? 'checked' : ''}} >{{$tag->name}}
          </label>
        @endforeach
      </div>
      <button type="submit" class="btn btn-primary">Save</a>
    </form>
    
  </div>
@endsection 