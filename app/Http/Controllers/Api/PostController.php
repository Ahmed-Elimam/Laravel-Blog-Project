<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::paginate(8);
        return PostResource::collection($post); //collection of objects
    }
    public function show($id){
        $post = Post::findOrFail($id);
        return new PostResource($post); //just one object
    }
    public function store(StorePostRequest $request){
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;
        $image = null;
        if($request->hasFile('image'))
        {
        $image = request()->file('image')->store('image','public');
        }
        $post = Post::create(['title'=> $title,'description'=> $description,'user_id'=> $postCreator,'image' => $image ?? null]);
        return new PostResource($post);
       }
}
