<?php

namespace App\Http\Controllers;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(){
        $posts = Post::paginate(8); //Select * from posts limit 8 by 8 (pagination)
        // $phpPosts = post::where('title','=','PHP')->get();//get()=>end of where condition
        // dd($posts, $phpPosts);//output is collection object
        return view('Posts.index',['posts' => $posts]);
    }

    public function show($id){
        $post = Post::find($id); //SELECT * FROM posts where id = 1 limit 1;
        // // $anotherSyntax = post::where('id','=',$id)->get(); //SELECT * FROM posts where id = 1;
        // // dd($post, $anotherSyntax);//output is collection object
        // $singlePost = post::where('id','=',$id)->first();//SELECT * FROM posts where id = 1 limit 1;
        return view('posts.show',['post' => $post]);
    }

    public function create(){
        $users =User::all();
        return view('posts.create',['post'=> null,'users'=> $users]);
    }

    public function store(StorePostRequest $request)
    {
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;
        $image = null;
        if($request->hasFile('image'))
        {
        $image = request()->file('image')->store('image','public');
        }
        $post = Post::create(['title'=> $title,'description'=> $description,'user_id'=> $postCreator,'image' => $image ?? null]);
        return to_route('posts.index', $post->id);
    }

    public function edit($id)
{
    $post = Post::find($id); //SELECT * FROM posts where id = 1 limit 1;
    $users = User::all();
    return view('posts.create', ['post' => $post, 'users' => $users]);
}
public function update(StorePostRequest $request, $id){
    $title = request()->title;
    $description = request()->description;
    $postCreator = request()->post_creator;
    $post = Post::find($id);
    $image = $post->image;
    if ($request->has('remove_image')) // Check if the remove_image checkbox is checked
    {     
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $image = null;
    }
    if ($request->hasFile('image')) {  // If a new image is uploaded, replace the old one
        // Delete old image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        // Store new image
        $image = $request->file('image')->store('posts', 'public');
    }
    $post->update(['title'=> $title,'description'=> $description,'user_id'=> $postCreator,'image'=> $image]);
    return to_route('posts.index');
}

public function destroy($id){
    $post = Post::find($id);
    if ($post->image) {
        Storage::disk('public')->delete($post->image);
    }
    $post->delete();
    return to_route('posts.index');
}
public function ajaxShow($id)
{
    $post = Post::findOrFail($id);
    return response()->json($post);
}

}
