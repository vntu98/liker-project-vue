<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        
    }

    public function store(Post $post, Request $request)
    {
        $this->authorize('like', $post);

        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return fractal()
            ->item($post->fresh()->loadCount('likes'))
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
