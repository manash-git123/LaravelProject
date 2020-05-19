@extends('layouts.app')
@section('content')
    <h1>Posts</h1>
    <p>
        @if (Auth::guest())


        @else
            <a href="posts/create" class="btn btn-primary">
                Create Post
            </a>
        @endif
    </p>
   
    @if(count($post)>0)
        @foreach($post as $posts)
             <div class="well">
                 <div class="row">
                    <div class="col-md-1 col-sm-1">
                        <img style="max-width:100%;max-height:100px;" src="storage/cover_images/{{$posts->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="posts/{{$posts->id}}">{!!$posts->title !!}</a></h3>
                        <h6>Written on {{ $posts->created_at     }}</h6>
                    </div>
                 </div>
            </div>
        @endforeach
        {{$post->links()}}
    @else
            <h3>No posts available....</h3>
    @endif
    
@endsection