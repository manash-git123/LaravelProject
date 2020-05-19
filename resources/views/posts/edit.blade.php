@extends('layout.app')
@section('content')
    <h1>Edit Post</h1>
    {{ Form::open(['action' => ['PostsController@update',$post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        <div class="form-group">
            {{Form::label('title','Title :')}}
            {{Form::text('title',$post->title,['class' => 'form-control', 'placeholder' => 'Title','style' => 'width : 50%;',])}}
        </div>
        <div class="form-group">
            {{Form::label('body','Content :')}}
            {{Form::textarea('body',$post->body,['id'=>'article-ckeditor','class' => 'form-control', 'placeholder' => 'Content','style' => 'width : 50%;'])}}
        </div>
        <div class="form-group">
            {{Form::label('cover_image','Upload your image (max 2MB) :')}}
            {{Form::file('cover_image','')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
    {{ Form::close() }}
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'article-ckeditor' );
        </script>
@endsection