<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::get();

        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "description" => "required"
        ]);
            $post = new Post();
            $post->user_id = auth()->user()->id;
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();
            return response()->json([
                'success' => true,
                'message' => 'Post created '
            ]);
        }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $post_id)
    {
        $user_id = auth()->user()->id;

        if (Post::where([
            "user_id" => $user_id,
            "id" => $post_id
        ])->exists()) {

            $post = Post::find($post_id);

            //print_r($request->all());die;

            $post->title = isset($request->title) ? $request->title : $post->title;
            $post->description = isset($request->description) ? $request->description : $post->description;

            $post->save();

            return response()->json([
                "status" => 1,
                "message" => "post updated"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => " Post doesn't exists"
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
      $post->delete();
    }
}
