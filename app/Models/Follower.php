<?php

namespace Postici\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $table = 'followers';

    public function user()
    {
        return $this->belongsTo(\Postici\Models\User::class, 'user_id');
    }

    public function follower()
    {
        return $this->belongsTo(\Postici\Models\User::class, 'follower_id');
    }
}
