@extends('layouts.dashboard')


    
@section('content')

<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mb-4">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">New Post</a>
                </div>
            
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Category</th>
                        <th>Tags</th>
                        <th scope="col">Actions</th>
                        
                    </tr>
                    </thead>
                    <tbody>

                        @foreach ($posts as $post)

                    <tr>          
                        <th scope="row">{{$post->id}}</th>
                        <td>{{$post->title}}</td>
                        <td>{{$post->content}}</td>
                        <td>{{$post->slug}}</td>
                        <td>{{$post->category ? $post->category->name : "-"}}</td>
                        <td>
                            @if(isset($post->tags))
                                @foreach ($post->tags as $tag)
                                    {{$tag->name}}
                                @endforeach
                            @endif
                        </td>
                        <td class="d-flex justify-content-start align-items-center">
                            <a href="{{route("admin.posts.show", $post->id)}}"><button type="button" class="btn btn-info">Show</button></a>
                            <a href="{{route("admin.posts.edit", $post->id)}}" class="mx-2"><button type="button" class="btn btn-success">Edit</button></a>
                            <form action="{{route("admin.posts.destroy", $post->id)}}" method="POST">
                                @csrf
                                @method("DELETE")
                            
                                <input class="btn btn-danger" type="submit" value="Delete">
                            </form>
                        </td>
                    
                    </tr>

                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</section>

@endsection