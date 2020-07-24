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
      <p><small>Slug: {{$post->slug}} </small></p>
      <div class="form-group">
        <label for="post-content">Content</label>
        <textarea class="form-control" id="post-content" name="content" placeholder="Inspiring post">{{old('content', $post->content)}}</textarea>
      </div>
      <div class="form-group">
        <label for="post-category">Content</label> 
        <select name="category_id" id="post-category" class="form-control">
          {{-- an empty value for the explanatory option makes it possible for the user to not choose a category without breaking everything --}}
          <option value="">Choose category</option>
          @foreach ($categories as $category)
            <option value="{{$category->id}}"
              @if ($post->category)
                {{old('category_id', $post->category->id) == $category->id ? 'selected' : ''}}
              @endif
              >{{$category->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <p>Tags</p>
        @foreach ($tags as $tag)
          <label class="form-check-label mr-1" for="post-tags">
            {{-- see the view admin.posts.create for why use tag_ids[] as name --}}
            <input type="checkbox" name="tag_ids[]" id="post-tags" value="{{$tag->id}}"
            {{-- //TODO: alternative, more difficult? method: "from the $post->tags collection, extract the column and make it into an array" --}}
            {{-- if there are errors it means that the values were sent and can thus be displayed through old() --}}
            @if ($errors->any())
              {{in_array($tag->id, old('tag_ids', [])) ? 'checked' : ''}}
              {{-- if there are no errors and we land in this page, it must mean there are no old values -> show what's in the database for that post --}}
            @else
              {{-- if no tags can be found $post->tags won't return an error, but an empty collection -> the evaluation can be made -> worst-case scenario, it evaluates to false --}}
              {{$post->tags->contains($tag) ? 'checked' : ''}}
            @endif
            >
            {{$tag->name}}
          </label>
        @endforeach
      </div>
      <button type="submit" class="btn btn-primary">Save</a>
    </form>
    
  </div>
@endsection 