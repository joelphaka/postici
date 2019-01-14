<?php

namespace Postici\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Postici\Models\Comment;
use Postici\Models\Post;
use Postici\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $this->getQuery($request);

        $counts = [
            'people' => User::findByTerm($q)->count(),
            'posts' => Post::findByTerm($q)->count(),
            'comments' => Comment::findByTerm($q)->count(),
        ];

        array_multisort($counts, SORT_DESC);

        $max_count = array_keys($counts)[0];

        return redirect()
            ->route("search.${max_count}", ['q' => $q]);
    }

    public function searchPeople(Request $request)
    {
        $people = User::findByTerm(self::getQuery($request))->paginate(1);

        return view('search.people')
            ->with('user', Auth::user())
            ->with('people', $people->appends(Input::except('page')));
    }

    public function searchPosts(Request $request)
    {
        $posts = Post::findByTerm(self::getQuery($request))
            ->paginate(1);

        return view('search.posts')
            ->with('user', Auth::user())
            ->with('posts', $posts->appends(Input::except('page')));
    }

    public function searchComments(Request $request)
    {
        $comments = Comment::findByTerm(self::getQuery($request))
            ->paginate(1);

        return view('search.comments')
            ->with('user', Auth::user())
            ->with('comments', $comments->appends(Input::except('page')));
    }

    private static function getQuery($arg)
    {
        $q = $arg instanceof Request ? $arg->query('q') : $arg;
        $q = str_replace('%', '', $q);

        if (!$q) return redirect()->route('home');

        return $q;
    }
}
