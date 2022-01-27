<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // user_idが１だけの人がadminとして入れる
        $user_id = \Auth::id();
        if ($user_id === 1){
            return $next($request);
        } else {
            return redirect(route('home'));
        }
        
    }
}
