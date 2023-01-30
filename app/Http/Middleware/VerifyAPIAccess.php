<?php


namespace App\Http\Middleware;

use App\Http\Controllers\Api\Base\ApiResponseTrait;
use Closure;
use Illuminate\Support\Facades\App;

class VerifyAPIAccess
{
	use ApiResponseTrait;
	
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (
			!(App::environment('local'))
			&& (
				!request()->hasHeader('X-AppApiToken')
				|| request()->header('X-AppApiToken') !== env('APP_API_TOKEN')
			)
		) {
			$message = 'You don\'t have access to this API.';
			
			return $this->respondUnAuthorized($message);
		}
		
		return $next($request);
	}
}
