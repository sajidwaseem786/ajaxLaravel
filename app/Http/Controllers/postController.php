<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use auth;
use Gate;
class postController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
     
        $this->middleware('auth')->except('index','search');
     
    }
    public function index()
    {
        //
        $posts=Post::paginate(3);
        return view('posts.index',compact('posts'))->with('i',(request()->input('page',1)-1)*3);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        
        $request->validate([
       "title"=>"required|min:5|max:25",
       "body"=>"required",
       "thumbnail"=>"required|image|mimes:jpg,png,jpeg,gif,svg|max:2048"

        ]);
      if($request->hasFile('thumbnail')&& $request->thumbnail->isValid()){

        $extension=$request->thumbnail->extension();

        $filename=time().'_.'.$extension;

        $request->thumbnail->move(public_path('images'),$filename);
      }
        $post=new Post;
       $result= $post->save([
            $post->title=$request->title,
            $post->body=$request->body,
            $post->image=$filename,
            $post->user_id=auth::user()->id,
        ]);
        if($result){
           return redirect('posts');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detailPost=Post::find($id);

        return view('posts.show',compact('detailPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
       $editAblePost=Post::find($id);
    //    if(Gate::allows('edit-post',$editAblePost)){
    //    return view('posts.edit',compact('editAblePost'));
    //    }
   
   if(auth::user()->can('update',$editAblePost)){

    return view('posts.edit',compact('editAblePost'));

   }
   else{

        return redirect('posts')->with(['msgClass'=>'alert-danger',"message"=>"You are not allowed to edit this post"]);

       }




    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $id=$request->input('id');

       $request->validate([
        "title"=>"required|min:5|max:25",
        "body"=>"required",
        
 
         ]);

       $previousPost=Post::find($id);
        
       $previousPost->title=$request->title;
       $previousPost->body=$request->body;
      
       if($result=$previousPost->update()){
           
        if($result){
            return redirect('posts');
         }
       }
    

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedPost=Post::find($id);

          $result=$deletedPost->delete();
          if($result){
            return redirect('posts');
         }

         
     
    }

    public function search(Request $request){
      $task=Post::where('title','LIKE',"%$request->term%")->pluck('title');
      if(empty($task->all()))
      return ['No Related Record'];
  else
      return $task;
  }

    
}
