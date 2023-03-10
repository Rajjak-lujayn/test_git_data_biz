<?php


namespace App\Http\Middleware;

use App\Helpers\Curl;
use App\Http\Controllers\Web\Install\Traits\Update\CleanUpTrait;
use App\Models\Permission;
use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class InstallationChecker
{
	use CleanUpTrait;
	
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @param null $guard
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if ($request->segment(1) == 'install') {
			// Check if installation is processing
			$InstallInProgress = false;
			if (
				!empty($request->session()->get('database_imported'))
				|| !empty($request->session()->get('cron_jobs'))
				|| !empty($request->session()->get('install_finish'))
			) {
				$InstallInProgress = true;
			}
			if ($this->alreadyInstalled($request) && !$InstallInProgress) {
				return redirect()->to('/');
			}
		} else {
			// Check if an update is available
			if (updateIsAvailable()) {
				if (auth()->check()) {
					$aclTableNames = config('permission.table_names');
					if (isset($aclTableNames['permissions'])) {
						if (Schema::hasTable($aclTableNames['permissions'])) {
							if (auth()->guard($guard)->user()->can(Permission::getStaffPermissions()) && !isDemoDomain()) {
								return redirect()->to(getRawBaseUrl() . '/upgrade');
							}
						}
					}
				} else {
					// Clear all the cache (TMP)
					$this->clearCache();
				}
			}
			
			// Check if the website is installed
			if (!$this->alreadyInstalled($request)) {
				return redirect()->to(getRawBaseUrl() . '/install');
			}
			
			//$this->checkPurchaseCode($request);
		}
		
		return $next($request);
	}
	
	/**
	 * If application is already installed.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function alreadyInstalled($request)
	{
		// Check if installation has just finished
		if (!empty($request->session()->get('install_finish'))) {
			// Write file
			File::put(storage_path('installed'), '');
			
			$request->session()->forget('install_finish');
			$request->session()->flush();
			
			// Redirect to the homepage after installation
			return redirect()->to('/');
		}
		
		// Check if the app is installed
		return appIsInstalled();
	}
	
	/**
	 * Check Purchase Code
	 * ===================
	 * Checking your purchase code. If you do not have one, please follow this link:
	 * https://codecanyon.net/item/laraclassified-geo-classified-ads-cms/16458425
	 * to acquire a valid code.
	 *
	 * IMPORTANT: Do not change this part of the code to prevent any data losing issue.
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	private function checkPurchaseCode($request)
	{
		$tab = [
			'install',
			admin_uri(),
		];
		
		// Don't check the purchase code for these areas (install, admin, etc. )
		if (!in_array($request->segment(1), $tab)) {
			// Make the purchase code verification only if 'installed' file exists
			if (file_exists(storage_path('installed')) && !config('settings.error')) {
				// Get purchase code from 'installed' file
				$purchaseCode = file_get_contents(storage_path('installed'));
				

					
					// Checking
					if ($data->valid == true) {
						file_put_contents(storage_path('installed'), $data->license_code);

				}
			}
		}
	}
}
