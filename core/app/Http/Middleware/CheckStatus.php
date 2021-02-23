<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

use Auth;
use Illuminate\Support\Facades\Request;
class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if((Auth::user()->phone_verify == 1 )&& (Auth::user()->email_verify == 1) && (Auth::user()->status == 1))
        {
            return $next($request);
        }else{
            return redirect()->route('user.authorization');
        }

    }
}
