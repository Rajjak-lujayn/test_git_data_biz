<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @param mixed ...$guards
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next, ...$guards)
	{
		$guards = empty($guards) ? [null] : $guards;
		
		foreach ($guards as $guard) {
			if (auth()->guard($guard)->check()) {
				if ($request->segment(1) == admin_uri()) {
					return redirect(admin_uri() . '/?login=success');
				} else {
					return redirect('/');
				}
			}
		}
		
		return $next($request);
	}
}
