<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    const MAX_LIKES = 5;

    protected $fillable = [
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function likers()
    {
        return $this->hasManyThrough(User::class, Like::class, 'likeable_id', 'id', 'id', 'user_id')
            ->where('likeable_type', Post::class)
            ->groupBy('likes.user_id', 'users.id', 'likes.likeable_id');
    }

    public function likesRemainingFor(User $user)
    {
        return self::MAX_LIKES - $this->likes->where('user_id', $user->id)->count();
    }

    public function maxLikesReachedFor(User $user)
    {
        return $this->likesRemainingFor($user) <= 0;
    }
}
