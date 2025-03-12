<?php

namespace App\Http\Controllers;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
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
        // dd($postCreator,$title,$description);
        // $post = new Post;
        // $post->Title = $title;
        // $post->description = $description;
        // $post->user_id = $postCreator;
        // $post->save();
        $post = Post::create(['title'=> $title,'description'=> $description,'user_id'=> $postCreator]);
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
    $post->update(['title'=> $title,'description'=> $description,'user_id'=> $postCreator]);
    return to_route('posts.index');
}

public function destroy($id){
    $post = Post::find($id);
    $post->delete();
    return to_route('posts.index');
}

}
