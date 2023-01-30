<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class ensureEmailRegistered
{

    public function handle(Request $request, Closure $next)
    {

        if(!$request->session()->exists('emailVarified')):
            // $request->session()->forget('emailVarified');
            // $request->session()->put('emailVarified', false);
            return response()->json(['status'=>'error','errors'=> ['email_registered'=> false]], 403);
        endif;

        return $next($request);
    }
}
