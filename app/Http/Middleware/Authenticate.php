<?php

namespace Postici\Http\Middleware;

use Closure;
use http\Url;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate
{
    /**
     * The Guard implementation
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized', 401);
            }

            return redirect()->guest(route('auth.signin', [
                'continue' => url()->full()
            ]));
        }

        return $next($request);
    }
}
