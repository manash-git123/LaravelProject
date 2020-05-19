<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
    /**
     * Add authentication on pages except index, show
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::orderBy('id','desc')->paginate(3);
        return view('posts.index',compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')){
            //File Uploading 
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Filename only
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // Extension Only
            $extension = pathinfo($filenameWithExt,PATHINFO_EXTENSION);
            // Final Filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Storing the file
            $path = $request->file('cover_image')->storeAs('public/cover_images',$filenameToStore);
        }else{
            $filenameToStore = 'noImage.jpg';
        }
        //Input the data into Database using Post model
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $filenameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(Auth()->User()->id != $post->user_id){
            return redirect('posts',compact('error','Not Your Post'));
        }
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'nullable|image|max: 1999'
        ]);
        $post = Post::find($id);

        if($request->hasFile('cover_image')){
            //File Uploading 
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Filename only
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // Extension Only
            $extension = pathinfo($filenameWithExt,PATHINFO_EXTENSION);
            // Final Filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Storing the file
            $path = $request->file('cover_image')->storeAs('public/cover_images',$filenameToStore);

            // Remove Previous Picture
            if($post->cover_image != 'noImage.jpg'){
                Storage::delete('public/cover_images/'.$post->cover_image);
            }
            
        }else{
            $filenameToStore = $post->cover_image;
        }

        //Update the data into Database using Post model
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $filenameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        // Remove Picture
        if($post->cover_image != 'noImage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Deleted');

    }
}
