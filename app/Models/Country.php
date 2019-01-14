<?php

namespace Postici\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $casts = [
        'id' => 'string'
    ];

    protected $table = 'countries';

    public function users()
    {
        return $this->hasMany(User::class, 'country_id');
    }
}
