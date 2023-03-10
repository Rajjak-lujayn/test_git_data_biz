<?php


namespace Larapen\Impersonate\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Lab404\Impersonate\Services\ImpersonateManager;
use Prologue\Alerts\Facades\Alert;

class ProtectFromImpersonation
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return  mixed
	 */
	public function handle($request, Closure $next)
	{
		$impersonate_manager = app()->make(ImpersonateManager::class);
		
		if ($impersonate_manager->isImpersonating()) {
			$message = t('Can not be accessed by an impersonator');
			
			if ($request->ajax()) {
				// Add a specific json attributes for 'bootstrap-fileinput' plugin
				if (
					Str::contains(Route::currentRouteAction(), 'EditController@updatePhoto')
					|| Str::contains(Route::currentRouteAction(), 'EditController@deletePhoto')
				) {
					// NOTE: 'bootstrap-fileinput' need 'error' (text) element & the optional 'errorkeys' (array) element
					$result = ['error' => $message];
				} else {
					$result = [
						'success' => false,
						'msg'     => $message,
					];
				}
				
				return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
			} else {
				if ($request->segment(1) == admin_uri()) {
					Alert::error($message)->flash();
				} else {
					flash($message)->error();
				}
				
				return redirect()->back();
			}
		}
		
		return $next($request);
	}
}
