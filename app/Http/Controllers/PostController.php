<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2018/12/21
 * Time: 21:57
 */

namespace Postici\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Postici\Models\Post;
use Postici\Models\User;

class PostController extends Controller
{
    public function index()
    {
        return Post::paginate();
    }

    public function show($id)
    {
        Post::findOrfail($id);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:6|max:64',
            'content' => 'required|min:6',
        ]);

        if ($validator->fails()) {

             return redirect()
                ->route('post.create')
                ->withErrors($validator)
                ->withInput();
        }

        Auth::user()->posts()->create([
            'title' => $request['title'],
            'content' => $request['content'],
            'is_public' => (boolean)$request['is_public']
        ]);

        return redirect()
            ->route('home')
            ->with('info', 'Your post was created')
            ->with('info_type', 'success');
    }

    public function edit($id)
    {
        $this->checkPost($id);

        return view('post.edit')
            ->with('post', Post::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->checkPost($id);
        abort_if($request['id'] != $id, 500, 'Tentative request');

        $this->validate($request, [
            'title' => 'required|min:6|max:64',
            'content' => 'required|min:6',
        ]);

        $post = Post::find($id);

        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->save();

        return redirect()
            ->route('post.edit', [$post])
            ->with('info', 'Post updated!')
            ->with('info_type', 'success');
    }

    public function destroy(Request $request, $id)
    {
        $this->checkPost($id);

        Post::find($id)->delete();

        return redirect()
            ->route('home')
            ->with('info', 'Post deleted!')
            ->with('info_type', 'success');
    }

    private function checkPost($id)
    {
        Post::findOrFail($id);
        abort_if(!Auth::user()->posts->where('id', $id)->count(), 500, 'Cannot edit post.');
    }
}