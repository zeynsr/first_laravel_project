<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Cache\TaggableStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.posts-index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('posts.posts-create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
//        $file = $request->file('image');
//        $fileName = time() . '_' . $file->getClientOriginalName();
//        $file->storeAs('public/images', $fileName);
//
//        $fileModel = new File();
//        $fileModel->name = $fileName;
//        $fileModel->path = 'storage/images/' . $fileName; // Path to file in storage directory
//        $fileModel->size = $file->getSize();
//        $fileModel->mime_type = $file->getMimeType();
//        $fileModel->description = 'User uploaded image';
//        $fileModel->save();

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->input('content');
        $post->short_content = $request->short_content;
        $post->category_id = $request->category_id;
//        $post->image = $request->file('image');
        $post->user_id = 1;

        $post->save();

        if($request->has('tags')){
            $post->tags()->attach($request->tags);
        }

        return redirect::route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $data = [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'tags_ids' => $post->getTagsIds()
        ];

        return view('posts.posts-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->content = $request->input('content');
        $post->short_content = $request->short_content;
        $post->category_id = $request->category_id;

        if($request->has('tags')){
            $post->tags()->sync($request->tags);
        }else{
            $post->tags()->detach();
        }

        $post->save();

        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect::route('post.index');
    }
}
