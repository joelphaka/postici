<?php

namespace Postici\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Postici\Models\Comment;
use Postici\Models\Like;
use Postici\Models\Post;
use Postici\Models\User;

class ProfileController extends Controller
{
    public function index($username)
    {
        $user = $this->getUserIfExists($username);

        return view('profile.index')
            ->with('user', $user);
    }

    public function getFollowing($username)
    {
        $user = $this->getUserIfExists($username);

        return view('profile.following')
            ->with('user', $user)
            ->with('people', $user->acceptedFollowing()->paginate(1));
    }

    public function getFollowers($username)
    {
        $user = $this->getUserIfExists($username);

        return view('profile.followers')
            ->with('user', $user)
            ->with('people', $user->acceptedFollowers()->paginate(1));
    }

    public function getFollow($id)
    {
        $user = User::findOrFail($id);

        abort_if($user->isAuthUser(), 500, 'Cannot follow yourself!');
        //die('Failed 1');
        abort_if(Auth::user()->following()->where('follower_id', $user->id)->first(), 500);
        //dd();
        //die('Failed 2');

        Auth::user()->following()->save($user);

        return redirect()->back()
            ->with('info', 'Follow request sent');
    }

    public function getUnfollow($id)
    {
        $user = Auth::user()->acceptedFollowing()
            ->where('follower_id', $id)->first();

        abort_if(!$user, 500);

        Auth::user()->following()->detach($user);

        return redirect()->back()
            ->with('info', "You have unfollowed {$user->getName()}");
    }

    public function getDeleteRequest($id)
    {
        $user = Auth::user()->pendingFollowing()
            ->where('follower_id', $id)->first();

        abort_if(!$user, 500);

        Auth::user()->following()->detach($user);

        return redirect()->back()
            ->with('info', "Request deleted.");
    }

    public function getAcceptRequest($id)
    {
        $user = Auth::user()->pendingFollowers()
            ->where('user_id', $id)->first();
        //dd($user);
        //die('');
        abort_if(!$user, 500, 'An error occured');

        Auth::user()->pendingFollowers()->updateExistingPivot([
            'user_id' => $id
        ],[
            'accepted' => true
        ]);

        Auth::user()->save();

        return redirect()->back()
            ->with('info', "Request accepted.");
    }

    public function getAvatar($username)
    {
        $user = $this->getUserIfExists($username);

        abort_if(!$user, 404);

        return response()->file($user->avatar());
    }

    public function uploadAvatar(Request $request)
    {
        $rules = [
            'imgfile'=> 'required|mimes:jpeg,png|max:1024',
        ];

        $customMessages = [
            'imgfile' => 'Please choose an image.',
            'imgfile.image' => 'The file must be an image of type jpeg or png.',
            'imgfile.mimes' => 'The file must be an image of type jpeg or png.',
            'imgfile.max' => 'The file may not be greater than 1024 kilobytes'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()
                ->back()
                ->with('info', $validator->errors()->first('imgfile'))
                ->with('info_type', 'danger');
        }

        Auth::user()->has_avatar = true;
        Auth::user()->save();

        $filename = Auth::user()->username . ".png";

        Storage::disk('avatars')->put($filename, File::get($request->file('imgfile')));

        sleep(3);

        return redirect()
            ->back()
            ->with('info', 'Your avatar has been changed.');
    }

    public function deleteAvatar()
    {
        if (Auth::user()->hasAvatar()) {
            File::delete(Auth::user()->avatar());
            Auth::user()->has_avatar = false;
            Auth::user()->save();

            return redirect()
                ->back()
                ->with('info', 'Your avatar has been removed.');
        } else {
            return redirect()
                ->back()
                ->with('info', "Your don't have an avatar. Why don't you upload one?");
        }
    }

    public function getTimeline($username)
    {
        $user = $this->getUserIfExists($username);

        return view('profile.timeline')
            ->with('user', $user)
            ->with('posts', $user->posts()
                ->latest('created_at')
                ->simplePaginate(1)
            );
    }

    public function getLikes($username)
    {
        return redirect()->route('user.likes.posts', ['username'=> $username]);
    }

    public function getPostLikes($username)
    {
        $user = $this->getUserIfExists($username);
        $likes = $user->likes()
            ->where('likeable_type', Post::class);

        return view('profile.likes-posts')
            ->with('user', $user)
            ->with('posts', Post::where(
                function ($query) use ($likes) {
                    return $query->whereIn('id', $likes->pluck('likeable_id'));
                })
                ->latest('created_at')
                ->simplePaginate(1)
            );
    }

    public function getCommentLikes($username)
    {
        $user = $this->getUserIfExists($username);
        $likes = $user->likes()
            ->where('likeable_type', Comment::class);

        return view('profile.likes-comments')
            ->with('user', $user)
            ->with('comments', Post::where(
                function ($query) use ($likes) {
                    return $query->whereIn('id', $likes->pluck('likeable_id'));
                })
                ->latest('created_at')
                ->simplePaginate(1)
            );
    }

    public function getLike($type, $id)
    {
        $type = strtolower($type);

        abort_if(!in_array($type, ['post', 'comment']), 500, 'Invalid type');

        $obj = ($type == 'post') ? Post::find($id) : Comment::find($id);

        abort_if(!$obj, 404, ucfirst($type) . ' not found');

        if (Auth::user()->hasLiked($obj)) {
            return redirect()->back();
        }

        $like = new Like();
        $like->likeable_type = get_class($obj);
        $like->likeable_id = $obj->id;
        $like->user_id = Auth::user()->id;

        $like->save();

        return redirect()->back();
    }

    public function getUnlike($type, $id)
    {
        $type = strtolower($type);

        abort_if(!in_array($type, ['post', 'comment']), 500, 'Invalid type');

        $obj = ($type == 'post') ? Post::find($id) : Comment::find($id);

        abort_if(!$obj, 404, ucfirst($type) . ' not found');

        if (!Auth::user()->hasLiked($obj)) {
            return redirect()->back();
        }

        Auth::user()->likes()
            ->where('likeable_type', get_class($obj))
            ->where('likeable_id', $obj->id)
            ->first()
            ->delete();

        return redirect()->back();
    }

    public function getLikeUsers($type, $id)
    {
        $type = strtolower($type);

        abort_if(!in_array($type, ['post', 'comment']), 404);

        $likes = Like::where('likeable_type', ($type == 'post') ? Post::class : Comment::class)
            ->where('likeable_id', $id);

        abort_if(!$likes->count(), 404);

        $people = User::where(function ($query) use ($likes) {
            $query->whereIn('id', $likes->pluck('user_id'));
        });

        return view('profile.like-users')
            ->with('user', Auth::user())
            ->with('people', $people->simplePaginate(1))
            ->with('likeable', $likes->first()->likeable()->first())
            ->with('type', $type);

    }

    public function getUserIfExists($username)
    {
        if (($user = User::where('username', $username)->first())) {
            return $user;
        }

        return abort(404, 'Not Found');
    }

}




