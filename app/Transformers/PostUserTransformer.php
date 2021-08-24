<?php

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostUserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'owner',
        'liked',
        'likes_remaining'
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
        return [];
    }

    public function includeOwner(Post $post)
    {
        return $this->primitive($post, function ($post) {
            return optional(auth()->user())->id === $post->user_id;
        });
    }

    public function includeLiked(Post $post)
    {
        return $this->primitive($post, function ($post) {
            if (!$user = auth()->user()) {
                return false;
            }

            return $post->likers->contains($user);
        });
    }

    public function includeLikesRemaining(Post $post)
    {
        return $this->primitive($post, function ($post) {
            if (!$user = auth()->user()) {
                return false;
            }

            return $post->likesRemainingFor($user);
        });
    }
}
