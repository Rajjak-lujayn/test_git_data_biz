<?php


namespace Larapen\Impersonate;

use Larapen\Impersonate\Middleware\ProtectFromImpersonation;

/**
 * Class ServiceProvider
 *
 * @package Lab404\Impersonate
 */
class ImpersonateServiceProvider extends \Lab404\Impersonate\ImpersonateServiceProvider
{
    /**
     * Register routes macro.
     *
     * @param   void
     * @return  void
     */
    protected function registerRoutesMacro()
    {
        $router = $this->app['router'];

        $router->macro('impersonate', function () use ($router) {
            $router->get('/impersonate/take/{id}', '\Larapen\Impersonate\Controllers\ImpersonateController@take')->name('impersonate');
            $router->get('/impersonate/leave', '\Larapen\Impersonate\Controllers\ImpersonateController@leave')->name('impersonate.leave');
        });
    }
	
	/**
	 * Register plugin middleware.
	 *
	 * @param   void
	 * @return  void
	 */
	public function registerMiddleware()
	{
		$this->app['router']->aliasMiddleware('impersonate.protect', ProtectFromImpersonation::class);
	}
}