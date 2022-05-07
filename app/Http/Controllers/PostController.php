<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
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
            'title' => 'required',
            'slug' => 'required|alpha_dash|unique:posts',
            'content' => 'required',
            'img' => 'required|image'
        ]);



        $post = new Post();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->img = 'storage/' . $request->file('img')->store('posts', 'public');
        $result = $post->save();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if ($post) {
            return response($post, 201);
        } else {
            return response([
                'message' => 'Post was not found'
            ], 404);
        }
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
        //
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
        $imagePath = public_path($post->img);
        File::delete($imagePath);
        $result = $post->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}