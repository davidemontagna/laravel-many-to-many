@extends('layouts.dashboard')

@section('title', 'Edit')
    
@section('content')    
    
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h3>Edit Post</h3>
                    <form action="{{ route("admin.posts.update", $post->id) }}" method="POST">                        
                        @csrf
                        @method('PUT')
            
                        <div class="mb-3">
                          <label for="title" class="form-label">Title</label>
                          <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" id="title" name="title" placeholder="Insert the title">   
                          @error('title')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror         
                        </div>
                        
                        <div class="mb-3">
                          <label for="content" class="form-label">Content</label>
                          <textarea type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="Insert the content">{{ old('content', $post->content) }}</textarea>    
                          @error('content')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror       
                        </div>

                        <div class="form-group">
                          <label>Category</label>
                          <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                              <option value="{{ $category->id }}" {{ $category->id == old('category_id', $post->category_id) ? 'selected' : '' }}> {{ $category->name }} </option>
                            @endforeach
                          </select>
                          @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label>Tags</label>
                          @foreach ($tags as $tag)
                              <div class="form-check">
                                <input type="checkbox" name="tags[]" class="form-check-input" value="{{$tag->id}}" id="{{$tag->slug}}" {{($post->tags->contains($tag)) ? " checked" : "" }}>
                                <label class="form-check-label" for="{{$tag->slug}}" >{{$tag->name}}</label>
                              </div>
                          @endforeach
                          @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        
                        <a href="{{ route("admin.posts.index") }}"><button type="submit" class="btn btn-primary">Submit</button></a>
                    </form>
            
                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                        
                    @endif
                </div>
            </div>
        </div>
    </section>
    
    
@endsection