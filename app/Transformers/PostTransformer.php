<?php

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'author',
        'likers',
        'user'
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        // 
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'body' => $post->body,
            'likes' => $post->likes_count
        ];
    }

    public function includeAuthor(Post $post)
    {
        return $this->item($post->user, new UserTransformer());
    }

    public function includeUser(Post $post)
    {
        return $this->item($post, new PostUserTransformer());
    }

    public function includeLikers(Post $post)
    {
        return $this->collection($post->likers, new UserTransformer());
    }
}
