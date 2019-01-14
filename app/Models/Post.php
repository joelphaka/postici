<?php

namespace Postici\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $fillable = [
        'title',
        'content',
        'is_public',
        'view_count',
        'user_id'
    ];

    public function getDateCreated()
    {
        if ($this->getAttribute('created_at') != null) {
            return new Carbon($this->getAttribute('created_at'));
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(\Postici\Models\User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public static function findByTerm($q)
    {
        $q = str_replace('%', '', $q);

        return Post::where('title', 'LIKE', "%{$q}%")
            ->orWhere('content', 'LIKE', "%{$q}%");
    }
}
