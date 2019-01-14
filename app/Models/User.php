<?php

namespace Postici\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $casts = [
        'birthdate' => 'date',
        'country_id' => 'string'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'birthdate',
        'gender',
        'biography',
        'country_id',
        'email',
        'username',
        'password',
        'has_avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')
            ->withTimestamps()
            ->withPivot(['accepted']);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')
            ->withTimestamps()
            ->withPivot(['accepted']);
    }

    public function isAuthUser()
    {
        if (Auth::check()) {
            return $this->getAttribute('id') == Auth::user()->id &&
                $this->getAttribute('username') == Auth::user()->username;
        }

        return false;
    }

    public function getName()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function hasLiked($obj)
    {
        if (!($obj instanceof Post || $obj instanceof Comment)) {
            return false;
        }

        return (bool) $obj->likes()
            ->where('likeable_id', $obj->id)
            ->where('likeable_type', get_class($obj))
            ->where('user_id', $this->id)
            ->count();
    }

    public function isFollowerOf(User $user)
    {
        return $this->acceptedFollowing()
            ->where('follower_id', $user->id)
            ->count();
    }

    public function isFollowedBy(User $user)
    {
        return (boolean)$this->acceptedFollowers()
            ->where('user_id', $user->id)
            ->count();
    }

    public function isRequestPending(User $user)
    {
        return (boolean)$this->pendingFollowing()
            ->where('follower_id', $user->id)
            ->count();
    }

    public function hasPendingRequestFrom(User $user)
    {
        return (boolean)$this->pendingFollowers()
            ->where('user_id', $user->id)
            ->count();
    }

    public function pendingRequestExists(User $user)
    {
        return $this->isRequestPending($user) || $this->hasPendingRequestFrom($user);
    }

    public function acceptedFollowers()
    {
        return $this->followers()->wherePivot('accepted', true);
    }

    public function acceptedFollowing()
    {
        return $this->following()->wherePivot('accepted', true);
    }

    public function pendingFollowers()
    {
        return $this->followers()->wherePivot('accepted', false);
    }

    public function pendingFollowing()
    {
        return $this->following()->wherePivot('accepted', false);
    }

    public function hasAvatar()
    {
        if ($this->has_avatar &&
            Storage::disk('local')->exists("avatars/{$this->username}.png")) {
            return true;
        }

        return false;
    }

    public function avatar()
    {
        if ($this->hasAvatar()) {

            return storage_path("app/avatars/{$this->username}.png");
        }

        return storage_path("app/avatars/user-icon.png");
    }

    public function saveLastSeen()
    {
        Auth::user()->last_seen = Carbon::now();
        Auth::user()->save();
    }

    public static function findByTerm($q)
    {
        $q = str_replace('%', '', $q);

        return User::where(DB::raw("CONCAT(firstname, ' ',lastname)"), 'LIKE', "%{$q}%")
            ->orWhere('firstname', 'LIKE', "%{$q}%")
            ->orWhere('lastname', 'LIKE', "%{$q}%")
            ->orWhere('username', 'LIKE', "%{$q}%");
    }
}



