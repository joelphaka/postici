<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2018/11/24
 * Time: 19:55
 */

namespace Postici\Http\Middleware;


use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            //Auth::user()->last_seen = Carbon::now();
        }

        return $next($request);
    }
}