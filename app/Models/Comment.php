<?php

namespace Postici\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'content',
        'parent_id',
        'user_id',
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(\Postici\Models\User::class, 'user_id');
    }

    public function parent()
    {
        $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public static function findByTerm($q)
    {
        $q = str_replace('%', '', $q);

        return Post::where('content', 'LIKE', "%{$q}%");
    }
}





