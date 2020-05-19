@extends('layouts.app')
@section('content')
    <h1>{!!$post->title!!}</h1>
    @if(count($post)>0)
             <div class="well" style="overflow-x: scroll;">
                <div class="row">
                    <div class="col-md-1 col-sm-1">
                        <img style="max-width:100%;max-height:100px;" src="../storage/cover_images/{{$post->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h4>{!!$post->body!!}</h4>
                        <h6>Written on {{ $post->created_at}}</h6>
                    </div>
                 </div>
                
            </div>

    @else
            <h3>No posts available....</h3>
    @endif
    @if(Auth()->User())
        @if($post->user_id == Auth()->User()->id)

            {{ Form::open(['action' => ['PostsController@destroy',$post->id], 'method' => 'POST']) }}
                {{Form::submit('Delete',['class' => 'btn btn-danger', 'style' => 'float : top;float : right;'])}}
                {{Form::hidden('_method','DELETE')}}
            {{Form::close()}}
            <a href="{{$post->id}}/edit" class="btn btn-success">
                Edit Post
            </a>
        @else

        @endif 
    @endif 
        
@endsection