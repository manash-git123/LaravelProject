@extends('layout.app')
@section('content')
    <h1>Create Post</h1>
    {{ Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        <div class="form-group">
            {{Form::label('title','Title :')}}
            {{Form::text('title','',['class' => 'form-control', 'placeholder' => 'Title','style' => 'width : 50%;'])}}
        </div>
        <div class="form-group">
            {{Form::label('body','Content :')}}
            {{Form::textarea('body','',['id'=>'article-ckeditor','class' => 'form-control', 'placeholder' => 'Content','style' => 'width : 50%;'])}}
        </div>
        <div class="form-group">
            <div class="form-group">
                {{Form::label('cover_image','Upload your image (max 2MB) :')}}
                <input type="file" name="cover_image" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
                               
                {{-- 
                 *********************************************************************
                    Can also be used but due to issues with javascript 
                 {{Form::file('cover_image','')}}  
                 *********************************************************************  
                 --}}

            </div>
            <div class="preview">
                <img id="file-ip-1-preview" style="max-height:200px;">
            </div>
        </div>
        {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
    {{ Form::close() }}
    <script type="text/javascript">
		function showPreview(event){
		  if(event.target.files.length > 0){
            //   Takes the source of the file uploaded
		    var src = URL.createObjectURL(event.target.files[0]);  
		    var preview = document.getElementById("file-ip-1-preview");
		    preview.src = src;
		    preview.style.display = "block";
		  }else{
		    preview.style.display = "none";
          }
		}
	</script>
    
    {{-- For converting the textarera into Editor using laravel-ckeditor --}}
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'article-ckeditor' );
        </script>
@endsection