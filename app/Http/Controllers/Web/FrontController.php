<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Traits\CommonTrait;
use App\Http\Controllers\Web\Traits\EnvFileTrait;
use App\Http\Controllers\Web\Traits\RobotsTxtTrait;
use App\Http\Controllers\Web\Traits\SettingsTrait;

class FrontController extends Controller
{
	use SettingsTrait, EnvFileTrait, RobotsTxtTrait, CommonTrait;
	
	public $request;
	public $data = [];
	
	/**
	 * FrontController constructor.
	 */
	public function __construct()
	{
		// Set the storage disk
		$this->setStorageDisk();
		
		// Check & Change the App Key (If needed)
		$this->checkAndGenerateAppKey();
		
		// Load the Plugins
		$this->loadPlugins();
		
		// Check & Update the '/.env' file
		$this->checkDotEnvEntries();
		
		// Check & Update the '/public/robots.txt' file
		$this->checkRobotsTxtFile();
		
		// From Laravel 5.3.4+
		$this->middleware(function ($request, $next)
		{
			// Load Localization Data first
			// Check out the SetCountryLocale Middleware
			$this->applyFrontSettings();
			
			return $next($request);
		});
		
		// Check the 'Currency Exchange' plugin
		if (config('plugins.currencyexchange.installed')) {
			$this->middleware(['currencies', 'currencyExchange']);
		}
		
		// Check the 'Domain Mapping' plugin
		if (config('plugins.domainmapping.installed')) {
			$this->middleware(['domain.verification']);
		}
	}
}
