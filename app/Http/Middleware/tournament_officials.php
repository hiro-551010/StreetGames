<?php

namespace App\Http\Middleware;

use App\Models\Host;
use App\Models\Player;
use Closure;
use Illuminate\Http\Request;

// player、hostかどうかのバリデーション
class tournament_officials
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        $hold_id = $request->route()->parameter('hold_id');
        $id = $request->route()->parameter('id');

        $player = Player::where('user_id', $id)->where('hold_id', $hold_id)->exists();
        $host = Host::where('user_id', $id)->where('hold_id', $hold_id)->exists();

        if($player or $host){
            return $next($request);
        }else{
            return redirect(route('home'));
        }
        
    }
}
