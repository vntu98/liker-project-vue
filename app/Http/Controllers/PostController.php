<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $posts = Post::withCount('likes')->latest()->get();

        return fractal()
            ->collection($posts)
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $post = $request->user()->posts()->create($request->only('body'));

        event(new PostCreated($post));

        return fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function update(Request $request)
    {

    }

    public function destroy(Post $post)
    {

    }
}
