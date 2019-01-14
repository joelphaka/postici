<?php

namespace Postici\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Postici\Models\Country;
use Postici\Models\Post;
use Postici\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index')
            ->with('user', Auth::user())
            ->with('posts', Post::latest('created_at')->SimplePaginate(2));
    }
}
