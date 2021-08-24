<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function like(User $user, Post $post)
    {
        if ($post->maxLikesReachedFor($user)) {
            return false;
        }

        if ($user->id === $post->user_id) {
            return false;
        }

        return true;
    }
}
