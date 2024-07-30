<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()->where('user_id', Auth::id())->get();
        return view('posts.posts-index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function UploadPhoto(Request $request)
    {
        $photoName = time() . '_' . $request->image->getClientOriginalName();
        $photo = $request->file('image');
        $file = new File();
        $file->name = $photoName;
        $file->path = public_path('photos') . $photoName;
        $file->type = $photo->getClientOriginalExtension();;
        $file->size = $photo->getSize();
        $photo->move(public_path('photos'), $photoName);
        return $file;
    }
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
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->input('content');
        $post->short_content = $request->short_content;
        $post->category_id = $request->category_id;
        $post->user_id = Auth::id();

        $post->save();

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        if ($request->has('image')) {

//          $path = $request->file('image')->store('public');
//          Storage::put(public_path('images'), $photo, 'public');
            $image = $this->UploadPhoto($request);
            $post->files()->save($image);
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
        $user = Auth::user();
        $post->title = $request->title;
        $post->content = $request->input('content');
        $post->short_content = $request->short_content;
        $post->category_id = $request->category_id;

        if ($user->hasRole('admin')) {
            $post->is_confirm = $request->is_confirm;
        }
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }
        if ($request->has('image')){
            if($post->files() != NULL)
            {
                $post->files()->delete();
            }
            $image = $this->UploadPhoto($request);
            $post->files()->save($image);
        }


        $post->save();

        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->files()->delete();
        $post->delete();
        return redirect::route('post.index');
    }

    public function display(Post $post)
    {
        $latestPost = Post::query()->where('is_confirm', 1)->latest()->take(3);
        return view('layout.home_display', compact('latestPost'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $post = Post::query()
            ->where('is_confirm', 1)
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orwhere('content', 'LIKE', "%{$search}%");
            })
            ->get();
        return view('layout.home_serach', compact('post'));
    }
}
