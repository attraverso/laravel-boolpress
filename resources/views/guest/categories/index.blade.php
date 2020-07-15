@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h1>Categories:</h1>
        </div>
        <div>
          <ul>
            @forelse ($categories as $category)
                <li>
                  <a href="{{route('categories.show', ['category' => $category->slug])}}">{{$category->name}}</a>
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