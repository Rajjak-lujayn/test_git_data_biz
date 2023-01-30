<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Web\PlanController;
use App\Http\Controllers\Web\Search\LiveSearch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\listingFileName;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Upgrading
|--------------------------------------------------------------------------
|
| The upgrading process routes
|
*/

Route::group([
	'namespace'  => 'App\Http\Controllers\Web\Install',
	'middleware' => ['web', 'no.http.cache'],
], function () {
	Route::get('upgrade', 'UpdateController@index');
	Route::post('upgrade/run', 'UpdateController@run');
});


/*
|--------------------------------------------------------------------------
| Installation
|--------------------------------------------------------------------------
|
| The installation process routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Web\Install',
	'middleware' => ['web', 'install.checker', 'no.http.cache'],
	'prefix'     => 'install',
], function () {
	Route::get('/', 'InstallController@starting');
	Route::get('site_info', 'InstallController@siteInfo');
	Route::post('site_info', 'InstallController@siteInfo');
	Route::get('system_compatibility', 'InstallController@systemCompatibility');
	Route::get('database', 'InstallController@database');
	Route::post('database', 'InstallController@database');
	Route::get('database_import', 'InstallController@databaseImport');
	Route::get('cron_jobs', 'InstallController@cronJobs');
	Route::get('finish', 'InstallController@finish');
});


/*
|--------------------------------------------------------------------------
| Back-end
|--------------------------------------------------------------------------
|
| The admin panel routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Admin',
	'middleware' => ['web', 'install.checker'],
	'prefix'     => config('larapen.admin.route', 'admin'),
], function ($router) {
	// Auth
	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::get('logout', 'Auth\LoginController@logout')->name('logout');

	// Password Reset Routes...
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset')->where('token', '.+');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

	// Admin Panel Area
	Route::group([
		'middleware' => ['admin', 'clearance', 'banned.user', 'no.http.cache'],
	], function ($router) {
		// Dashboard
		Route::get('dashboard', 'DashboardController@dashboard');
		Route::get('/', 'DashboardController@redirect');

		// Extra (must be called before CRUD)
		Route::get('homepage/{action}', 'HomeSectionController@reset')->where('action', 'reset_(.*)');
		Route::get('languages/sync_files', 'LanguageController@syncFilesLines');
		Route::get('languages/texts/{lang?}/{file?}', 'LanguageController@showTexts')->where('lang', '.*')->where('file', '.*');
		Route::post('languages/texts/{lang}/{file}', 'LanguageController@updateTexts')->where('lang', '.*')->where('file', '.+');
		Route::get('permissions/create_default_entries', 'PermissionController@createDefaultEntries');
		Route::get('blacklists/add', 'BlacklistController@banUserByEmail');
		Route::get('categories/rebuild-nested-set-nodes', 'CategoryController@rebuildNestedSetNodes');

		// CRUD
		CRUD::resource('advertisings', 'AdvertisingController');
		CRUD::resource('blacklists', 'BlacklistController');
		CRUD::resource('categories', 'CategoryController');


		CRUD::resource('categories/{catId}/subcategories', 'CategoryController');
		CRUD::resource('categories/{catId}/custom_fields', 'CategoryFieldController');
		CRUD::resource('cities', 'CityController');
		// CRUD::resource('countries', 'CountryController');
		// CRUD::resource('countries/{countryCode}/cities', 'CityController');
		// CRUD::resource('countries/{countryCode}/admins1', 'SubAdmin1Controller');
		CRUD::resource('currencies', 'CurrencyController');
		CRUD::resource('custom_fields', 'FieldController');
		CRUD::resource('custom_fields/{cfId}/options', 'FieldOptionController');
		CRUD::resource('custom_fields/{cfId}/categories', 'CategoryFieldController');
		CRUD::resource('genders', 'GenderController');
		CRUD::resource('homepage', 'HomeSectionController');
		CRUD::resource('admins1/{admin1Code}/cities', 'CityController');
		CRUD::resource('admins1/{admin1Code}/admins2', 'SubAdmin2Controller');
		CRUD::resource('admins2/{admin2Code}/cities', 'CityController');
		CRUD::resource('languages', 'LanguageController');
		CRUD::resource('meta_tags', 'MetaTagController');
		CRUD::resource('packages', 'PackageController');
		CRUD::resource('pages', 'PageController');
		CRUD::resource('payments', 'PaymentController');
		CRUD::resource('orders', 'OrderController');
		CRUD::resource('payment_methods', 'PaymentMethodController');
		CRUD::resource('permissions', 'PermissionController');
		CRUD::resource('pictures', 'PictureController');
		CRUD::resource('posts', 'PostController');
		CRUD::resource('lists', 'ListsController');
		CRUD::resource('p_types', 'PostTypeController');
		CRUD::resource('report_types', 'ReportTypeController');
		CRUD::resource('roles', 'RoleController');
		CRUD::resource('settings', 'SettingController');
		CRUD::resource('time_zones', 'TimeZoneController');
		CRUD::resource('users', 'UserController');

		// Others
		Route::get('account', 'UserController@account');
		Route::post('ajax/{table}/{field}', 'InlineRequestController@make')->where('table', '.+')->where('field', '.+');
		// Import 
		Route::get('import_data', 'ImportListController@index');
		Route::post('/import_parse', 'ImportListController@parseImport')->name('import_parse');
		Route::post('/import_process', 'ImportListController@processImport')->name('import_process');

		// changes by rajjak dec 29 for create routes for csv import file name 
		Route::get('listingFileData', 'ImportListController@fileData')->name('file_data');
		// Route::get('file_data', [listingFileName::class, 'file_data'])->name('file_data');
		Route::get('listingFileData/{id}', [listingFileName::class, 'fileDelete'])->name('fileDelete');
		Route::get('listingFileData/download/{id}', [listingFileName::class, 'download'])->name('download');
		// end
		// Backup
		Route::get('backups', 'BackupController@index');
		Route::put('backups/create', 'BackupController@create');
		Route::get('backups/download/{file_name?}', 'BackupController@download')->where('file_name', '.*');
		Route::delete('backups/delete/{file_name?}', 'BackupController@delete')->where('file_name', '.*');

		// Actions
		Route::get('actions/clear_cache', 'ActionController@clearCache');
		Route::get('actions/clear_images_thumbnails', 'ActionController@clearImagesThumbnails');
		Route::get('actions/maintenance/{mode}', 'ActionController@maintenance')->where('mode', 'down|up');

		// Re-send Email or Phone verification message
		$router->pattern('id', '[0-9]+');
		Route::get('users/{id}/verify/resend/email', 'UserController@reSendEmailVerification');
		Route::get('users/{id}/verify/resend/sms', 'UserController@reSendPhoneVerification');
		Route::get('posts/{id}/verify/resend/email', 'PostController@reSendEmailVerification');
		Route::get('posts/{id}/verify/resend/sms', 'PostController@reSendPhoneVerification');

		// Plugins
		$router->pattern('plugin', '.+');
		Route::get('plugins', 'PluginController@index');
		Route::post('plugins/{plugin}/install', 'PluginController@install');
		Route::get('plugins/{plugin}/install', 'PluginController@install');
		Route::get('plugins/{plugin}/uninstall', 'PluginController@uninstall');
		Route::get('plugins/{plugin}/delete', 'PluginController@delete');

		// System Info
		Route::get('system', 'SystemController@systemInfo');
	});
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The not translated front-end routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Web',
	'middleware' => ['web', 'install.checker'],
], function ($router) {
	// Select Language
	Route::get('lang/{code}', 'Locale\SetLocaleController@redirect');

	// FILES
	Route::get('file', 'FileController@show');
	Route::get('js/fileinput/locales/{code}.js', 'FileController@fileInputLocales');

	// SEO
	Route::get('sitemaps.xml', 'SitemapsController@index');

	// Impersonate (As admin user, login as an another user)
	Route::group(['middleware' => 'auth'], function ($router) {
		Route::impersonate();
	});
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The translated front-end routes
|
*/
Route::group([
	'namespace' => 'App\Http\Controllers\Web',
], function ($router) {
	Route::group(['middleware' => ['web', 'install.checker']], function ($router) {
		// Country Code Pattern
		$countryCodePattern = implode('|', array_map('strtolower', array_keys(getCountries())));
		$countryCodePattern = !empty($countryCodePattern) ? $countryCodePattern : 'us';
		/*
		 * NOTE:
		 * '(?i:foo)' : Make 'foo' case-insensitive
		 */
		$countryCodePattern = '(?i:' . $countryCodePattern . ')';
		$router->pattern('countryCode', $countryCodePattern);


		// HOMEPAGE
		Route::get('/', 'HomeController@index');
			Route::get(dynamicRoute('routes.countries'), 'CountriesController@index');

		// AUTH
		Route::group(['middleware' => ['guest', 'no.http.cache']], function ($router) {
			// Registration Routes...
			Route::get(dynamicRoute('routes.register'), 'Auth\RegisterController@showRegistrationForm');
			Route::post(dynamicRoute('routes.register'), 'Auth\RegisterController@register');
			Route::get('register/finish', 'Auth\RegisterController@finish');

			// Authentication Routes...
			Route::get(dynamicRoute('routes.login'), 'Auth\LoginController@showLoginForm');
			Route::post(dynamicRoute('routes.login'), 'Auth\LoginController@login');

			// Forgot Password Routes...
			Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
			Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLink');

			// Reset Password using Token
			Route::get('password/token', 'Auth\ResetPasswordController@showTokenRequestForm');
			Route::post('password/token', 'Auth\ResetPasswordController@sendResetToken');

			// Reset Password using Link (Core Routes...)
			Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
			Route::post('password/reset', 'Auth\ResetPasswordController@reset');

			// Social Authentication
			$router->pattern('provider', 'facebook|linkedin|twitter|google');
			Route::get('auth/{provider}', 'Auth\SocialController@redirectToProvider');
			Route::get('auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback');
		});

		// Email Address or Phone Number verification
		$router->pattern('field', 'email|phone');
		Route::get('users/{id}/verify/resend/email', 'Auth\RegisterController@reSendEmailVerification');
		Route::get('users/{id}/verify/resend/sms', 'Auth\RegisterController@reSendPhoneVerification');
		Route::get('users/verify/{field}/{token?}', 'Auth\RegisterController@verification');
		Route::post('users/verify/{field}/{token?}', 'Auth\RegisterController@verification');

		// User Logout
		Route::get(dynamicRoute('routes.logout'), 'Auth\LoginController@logout');


		// POSTS
		Route::group(['namespace' => 'Post'], function ($router) {
			$router->pattern('id', '[0-9]+');
			// $router->pattern('slug', '.*');
			$bannedSlugs = collect(config('routes'))->filter(function ($value, $key) {
				return (!Str::contains($key, '.') && !empty($value));
			})->flatten()->toArray();
			if (!empty($bannedSlugs)) {
				/*
				 * NOTE:
				 * '^(?!companies|users)$' : Don't match 'companies' or 'users'
				 * '^(?=.*)$'              : Match any character
				 * '^((?!\/).)*$'          : Match any character, but don't match string with '/'
				 */
				$router->pattern('slug', '^(?!' . implode('|', $bannedSlugs) . ')(?=.*)((?!\/).)*$');
			} else {
				$router->pattern('slug', '^(?=.*)((?!\/).)*$');
			}

			// SingleStep Post creation
			Route::group(['namespace' => 'CreateOrEdit\SingleStep'], function ($router) {
				Route::get('create', 'CreateController@getForm');
				Route::post('create', 'CreateController@postForm');
				Route::get('create/finish', 'CreateController@finish');

				// Payment Gateway Success & Cancel
				Route::get('create/payment/success', 'CreateController@paymentConfirmation');
				Route::get('create/payment/cancel', 'CreateController@paymentCancel');
				Route::post('create/payment/success', 'CreateController@paymentConfirmation');

				// Email Address or Phone Number verification
				$router->pattern('field', 'email|phone');
				Route::get('posts/{id}/verify/resend/email', 'CreateController@reSendEmailVerification');
				Route::get('posts/{id}/verify/resend/sms', 'CreateController@reSendPhoneVerification');
				Route::get('posts/verify/{field}/{token?}', 'CreateController@verification');
				Route::post('posts/verify/{field}/{token?}', 'CreateController@verification');
			});

			// MultiSteps Post creation
			Route::group(['namespace' => 'CreateOrEdit\MultiSteps'], function ($router) {
				Route::get('posts/create', 'CreateController@getPostStep');
				Route::post('posts/create', 'CreateController@postPostStep');
				Route::get('posts/create/photos', 'CreateController@getPicturesStep');
				Route::post('posts/create/photos', 'CreateController@postPicturesStep');
				Route::post('posts/create/photos/{photoId}/delete', 'CreateController@removePicture');
				Route::post('posts/create/photos/reorder', 'CreateController@reorderPictures');
				Route::get('posts/create/payment', 'CreateController@getPaymentStep');
				Route::post('posts/create/payment', 'CreateController@postPaymentStep');
				Route::post('posts/create/finish', 'CreateController@finish');
				Route::get('posts/create/finish', 'CreateController@finish');

				// Payment Gateway Success & Cancel
				Route::get('posts/create/payment/success', 'CreateController@paymentConfirmation');
				Route::post('posts/create/payment/success', 'CreateController@paymentConfirmation');
				Route::get('posts/create/payment/cancel', 'CreateController@paymentCancel');

				// Email Address or Phone Number verification
				$router->pattern('field', 'email|phone');
				Route::get('posts/{id}/verify/resend/email', 'CreateController@reSendEmailVerification');
				Route::get('posts/{id}/verify/resend/sms', 'CreateController@reSendPhoneVerification');
				Route::get('posts/verify/{field}/{token?}', 'CreateController@verification');
				Route::post('posts/verify/{field}/{token?}', 'CreateController@verification');
			});

			Route::group(['middleware' => ['auth']], function ($router) {
				$router->pattern('id', '[0-9]+');

				// SingleStep Post edition
				Route::group(['namespace' => 'CreateOrEdit\SingleStep'], function ($router) {
					Route::get('edit/{id}', 'EditController@getForm');
					Route::put('edit/{id}', 'EditController@postForm');

					// Payment Gateway Success & Cancel
					Route::get('edit/{id}/payment/success', 'EditController@paymentConfirmation');
					Route::get('edit/{id}/payment/cancel', 'EditController@paymentCancel');
					Route::post('edit/{id}/payment/success', 'EditController@paymentConfirmation');
				});

				// MultiSteps Post edition
				Route::group(['namespace' => 'CreateOrEdit\MultiSteps'], function ($router) {
					Route::get('posts/{id}/edit', 'EditController@getForm');
					Route::put('posts/{id}/edit', 'EditController@postForm');
					Route::get('posts/{id}/photos', 'PhotoController@getForm');
					Route::post('posts/{id}/photos', 'PhotoController@postForm');
					Route::post('posts/{id}/photos/{photoId}/delete', 'PhotoController@delete');
					Route::post('posts/{id}/photos/reorder', 'PhotoController@reorder');
					Route::get('posts/{id}/payment', 'PaymentController@getForm');
					Route::post('posts/{id}/payment', 'PaymentController@postForm');

					// Payment Gateway Success & Cancel
					Route::get('posts/{id}/payment/success', 'PaymentController@paymentConfirmation');
					Route::post('posts/{id}/payment/success', 'PaymentController@paymentConfirmation');
					Route::get('posts/{id}/payment/cancel', 'PaymentController@paymentCancel');
				});
			});

			// Post's Details
			Route::get(dynamicRoute('routes.post'), 'DetailsController@index');

			// Send report abuse
			Route::get('posts/{id}/report', 'ReportController@showReportForm');
			Route::post('posts/{id}/report', 'ReportController@sendReport');
		});


		// ACCOUNT
		Route::group(['prefix' => 'account'], function ($router) {
			// Messenger
			// Contact Post's Author
			Route::group([
				'namespace' => 'Account',
				'prefix'    => 'messages',
			], function ($router) {
				Route::post('posts/{id}', 'MessagesController@store');
			});

			Route::group([
				'middleware' => ['auth', 'banned.user', 'no.http.cache'],
				'namespace'  => 'Account',
			], function ($router) {
				$router->pattern('id', '[0-9]+');

				// Users
				Route::get('/', 'EditController@index');
				Route::group(['middleware' => 'impersonate.protect'], function () {
					Route::put('/', 'EditController@updateDetails');
					Route::put('settings', 'EditController@updateDetails');
					Route::put('photo', 'EditController@updatePhoto');
					Route::put('photo/delete', 'EditController@updatePhoto');
				});
				Route::get('close', 'CloseController@index');
				Route::group(['middleware' => 'impersonate.protect'], function () {
					Route::post('close', 'CloseController@submit');
				});

				// Posts
				Route::get('saved-search', 'PostsController@getSavedSearch');
				$router->pattern('pagePath', '(my-posts|archived|favourite|pending-approval|saved-search)+');
				Route::get('{pagePath}', 'PostsController@getPage');
				Route::get('my-posts/{id}/offline', 'PostsController@getMyPosts');
				Route::get('archived/{id}/repost', 'PostsController@getArchivedPosts');
				Route::get('{pagePath}/{id}/delete', 'PostsController@destroy');
				Route::post('{pagePath}/delete', 'PostsController@destroy');

				// Messenger
				Route::group(['prefix' => 'messages'], function ($router) {
					$router->pattern('id', '[0-9]+');
					Route::post('check-new', 'MessagesController@checkNew');
					Route::get('/', 'MessagesController@index');
					// Route::get('create', 'MessagesController@create');
					Route::post('/', 'MessagesController@store');
					Route::get('{id}', 'MessagesController@show');
					Route::put('{id}', 'MessagesController@update');
					Route::get('{id}/actions', 'MessagesController@actions');
					Route::post('actions', 'MessagesController@actions');
					Route::get('{id}/delete', 'MessagesController@destroy');
					Route::post('delete', 'MessagesController@destroy');
				});

				// Transactions
				Route::get('transactions', 'TransactionsController@index');
				Route::get('orders', 'OrdersController@index')->name('orders');
			});
		});


		// AJAX
		Route::group(['prefix' => 'ajax'], function ($router) {
			Route::get('countries/{countryCode}/admins/{adminType}', 'Ajax\LocationController@getAdmins');
			Route::get('countries/{countryCode}/admins/{adminType}/{adminCode}/cities', 'Ajax\LocationController@getCities');
			Route::get('countries/{countryCode}/cities/{id}', 'Ajax\LocationController@getSelectedCity');
			Route::post('countries/{countryCode}/cities/autocomplete', 'Ajax\LocationController@searchedCities');
			Route::post('countries/{countryCode}/admin1/cities', 'Ajax\LocationController@getAdmin1WithCities');
			Route::post('category/select-category', 'Ajax\CategoryController@getCategoriesHtml');
			Route::post('category/custom-fields', 'Ajax\CategoryController@getCustomFields');
			Route::post('save/post', 'Ajax\PostController@savePost');
			Route::post('save/search', 'Ajax\PostController@saveSearch');
			Route::post('post/phone', 'Ajax\PostController@getPhone');
		});


		// FEEDS
		Route::feeds();


		// SITEMAPS (XML)
		Route::get('{countryCode}/sitemaps.xml', 'SitemapsController@site');
		Route::get('{countryCode}/sitemaps/pages.xml', 'SitemapsController@pages');
		Route::get('{countryCode}/sitemaps/categories.xml', 'SitemapsController@categories');
		Route::get('{countryCode}/sitemaps/cities.xml', 'SitemapsController@cities');
		Route::get('{countryCode}/sitemaps/posts.xml', 'SitemapsController@posts');


		// PAGES
		Route::get(dynamicRoute('routes.pricing'), 'PageController@pricing');
		Route::get(dynamicRoute('routes.pageBySlug'), 'PageController@cms');
		Route::get(dynamicRoute('routes.contact'), 'PageController@contact');
		Route::post(dynamicRoute('routes.contact'), 'PageController@contactPost');

		// SITEMAP (HTML)
		Route::get(dynamicRoute('routes.sitemap'), 'SitemapController@index');

		Route::group(['namespace' => 'Search'], function ($router) {
			// changes by rajjak jan 12 and 13 and 17, 2023 for crate route to filter (website, title and company) function
			Route::get('/live_search/get_website', 'LiveSearch@get_website')->name('live_search.get_website');
			Route::get('/live_search/get_title', 'LiveSearch@get_title')->name('live_search.get_title');
			Route::get('/live_search/get_company', 'LiveSearch@get_company')->name('live_search.get_company');

			//end
			Route::get('/live_search/get_industries', 'LiveSearch@get_industries')->name('live_search.get_industries');
			Route::get('/live_search/get_countries', 'LiveSearch@get_countries')->name('live_search.get_countries');
			Route::get('/live_search/get_employeesize', 'LiveSearch@get_employeesize')->name('live_search.get_employeesize');
			Route::get('/live_search/update_user_record', 'LiveSearch@update_record')->name('live_search.update_record');

			Route::get('/live_search/exportCsv', 'LiveSearch@exportCsv')->name('live_search.exportCsv');
		});

		Route::group(['middleware' => 'auth'], function () {
			//	Route::get('/home', 'HomeController@index')->name('home');
			Route::get('/plans', 'PlanController@index')->name('plans.index');

			Route::get('/checkout/plan/{plan_id}', 'PlanController@checkout')->name('plans.checkout');

			Route::post('plans', 'PlanController@stripePost')->name('stripe.post');
		});
		// SEARCH
		Route::group(['middleware' => ['auth', 'banned.user', 'no.http.cache'], 'namespace' => 'Search'], function ($router) {
			$router->pattern('id', '[0-9]+');
			$router->pattern('username', '[a-zA-Z0-9]+');
			Route::get('live_search', 'LiveSearch@index')->name('live_search.index');
			Route::get('/live_search/action', 'LiveSearch@getData')->name('live_search.action');

			Route::get(dynamicRoute('routes.search'), 'SearchController@index');
			Route::get(dynamicRoute('routes.searchPostsByUserId'), 'UserController@index');
			Route::get(dynamicRoute('routes.searchPostsByUsername'), 'UserController@profile');
			Route::get(dynamicRoute('routes.searchPostsByTag'), 'TagController@index');
			Route::get(dynamicRoute('routes.searchPostsByCity'), 'CityController@index');
			Route::get(dynamicRoute('routes.searchPostsBySubCat'), 'CategoryController@index');
			Route::get(dynamicRoute('routes.searchPostsByCat'), 'CategoryController@index');
		});
	});
});

Route::post('/save_search_query', "App\Http\Controllers\Web\Search\LiveSearch@saveSearchQuery");
Route::post('/getSavedSearchQuery', "App\Http\Controllers\Web\Search\LiveSearch@getSavedSearchQuery");


Route::get('listing-cron', function () {
	$lr_listing = DB::table('new_listing')->where('cron_flag', '=', 0)->limit(500)->get();

	DB::table('listing')->update(['read_flag' => '0']);
	// Mail::raw('Data Update Cron Of Data.bizprospex Runs', function($message) {
	// 	$message -> from('amir.s.lujayninfoways@gmail.com', 'Data Update Cron Of Data.bizprospex');
	// 	$message -> to('kalpesh.lujayninfoways@gmail.com');
	// 	$message -> subject('Data.bizb2b Data Update Cron Run');
	//  });  

	if ($lr_listing) {
		foreach ($lr_listing as $list) {

			// dd($list);
			$listing = DB::table('listing')->where('Email', '=', $list->Email)->get();
			if (!$listing->isEmpty()) {
				$test = array_diff((array)$list, (array)$listing[0]);
				// array_shift($a)
				if ($test) {
					DB::table('listing')
						->where('id', $listing[0]->id)
						->update($test);
					DB::table('listing')
						->where('id', $list->id)
						->update(['read_flag' => '1']);
					DB::table('new_listing')
						->where('id', $list->id)
						->update(['cron_flag' => '1']);
				}
			} else {
				$listArray = (array)$list;
				// changes by rajjak for employee remove space and employee text
				$employee = $listArray['EmplyoeeSize'];
				
				$test_split = str_replace(' ', '', $employee);
				$update_employee = trim($test_split,"employees");
				// end

				// chnges by rajjak for converted revenue in alphanumeri between new_listing to listing
				$input = $listArray['Revenue'];
				$aray = [];
				$space_replace = str_replace(' ', '', $input);
				$replace_char = str_replace(array('\'', '"', ',', '?', '$', ';', '<', '>'), ' ', $space_replace);
				$input_string_replace = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $replace_char);

				if (isset($input_string_replace[1])) {
					foreach (explode('-', $input) as $key => $info) {
						//check for special char.
						$str_split = str_split(trim($info));

						$space_replace = str_replace(' ', '', $info);  // remove space
						$string_replace = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $space_replace);
						$replace_char = str_replace(array('\'', '"', ',', '$', ';', '<', '>'), ' ', $string_replace); // remove special char.
						$a = $replace_char[1];
						$no_k = str_replace($a, "", $replace_char[0]);
						$dotted = trim(str_replace(",", ".", $no_k));
						// dd($dotted);
						 
						if ($a == 'USD') {
							$aray[$key] = $dotted * 1;
						} 
						elseif ($a == 'THOUSANDUSD') {
							$aray[$key] = $dotted * 1000;
						}	
						elseif ($a == 'MILLIONUSD') {
							$aray[$key] = $dotted * 1000000;
						} elseif ($a == 'BILLIONUSD') {
							$aray[$key] = $dotted * 1000000000;
						}
					}

					$listArray['Revenue'] = implode("-", $aray);
				} else {

					$listArray['Revenue'] = $input_string_replace[0];
				}
				// end
				// changes by rajjak fo employee
				$listArray['EmplyoeeSize'] = $update_employee;
				// end
				DB::table('listing')->insert($listArray);

				DB::table('listing')
					->where('id', $list->id)
					->update(['read_flag' => '1']);

				DB::table('new_listing')
					->where('id', $list->id)
					->update(['cron_flag' => '1']);
			}
		}
	}
	// Mail::raw('Data Update Cron Of Data.bizprospex Runs End', function($message) {
	// 	$message -> from('amir.s.lujayninfoways@gmail.com', 'Data Update Cron Of Data.bizprospex');
	// 	$message -> to('kalpesh.lujayninfoways@gmail.com');
	// 	$message -> subject('Data.bizb2b Data Update Cron End run');
	//  });  

})->name('plans.index1');


// change by rajjak
//  for update old data

// Route::get('update-cron', function () {
// 	$lr_listing_update = DB::table('listing')->select('Revenue', 'id')->where('update_flag', '=', 0)->limit(500)->get();
// 	foreach ($lr_listing_update as $value) {
// 		if ($value->Revenue != '' /*&& $value->Revenue != '$1 mil. - $5 mil. $2,400,000' && $value->Revenue != '$1 mil. - $5 mil. $1,400,000'  && $value->Revenue != 'Over $5 bil.' && $value->Revenue != '$500,000 - $1 mil' && $value->Revenue != '? $1 mil. - $5 mil. $2,400,000' && $value->Revenue != '$500,000 - $1 mil.' && $value->Revenue != '? $5 mil. - $10 mil. $7,000,000' && $value->Revenue != '? $1 mil. - $5 mil. $3,000,000' && $value->Revenue != '? $5 mil. - $10 mil. $7,500,000' && $value->Revenue != '$500,000 - $1 mil. $750,000' && $value->Revenue != 'Under $500,000' && $value->Revenue != '$1 mil. - $5 mil. $2,000,000'*/) {
// 			// dd($value->Revenue);
// 			$Revenue_value = trim($value->Revenue);
// 			$aray = [];
// 			$space_replace = str_replace(' ', '', $Revenue_value);
// 			$replace_char = trim(str_replace(array('\'', '"', ',', '?', '$', ';', '<', '>'), ' ', $space_replace));
// 			$input_string_replace = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $replace_char);
// 			if (isset($input_string_replace[1])) {
// 				foreach (explode('-', $Revenue_value) as $key => $info) {
// 					$space_replace = trim(str_replace(' ', '', $info));
// 					$replace_char = trim(str_replace(array('\'', '"', ',', '?', '$', ';', '<', '>'), ' ', $space_replace));
// 					$split_string = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $replace_char);
// 					$a = $split_string[1];
// 					$no_k = str_replace($a, "", $split_string[0]);
// 					$dotted = str_replace(",", ".", $no_k);
// 					if ($a == 'K') {
// 						$aray[$key] = $dotted * 1000;
// 					} elseif ($a == 'M' || $a == 'mil' || $a == 'Mil' || $a == 'mil.' || $a == 'MIL' || $a == 'Mil'  || $a == 'Mil.' || $a == 'Million') {
// 						$aray[$key] = $dotted * 1000000;
// 					} elseif ($a == 'B' || $a == 'bil' || $a == 'Bil' || $a == 'bil.' || $a == 'BIL' || $a == 'Bil'  || $a == 'Bil.' || $a == 'Billion') {
// 						$aray[$key] = $dotted * 1000000000;
// 					}
// 				}
// 				$Revenue = implode('-', $aray);
// 				// dd($Revenue);

// 				DB::table('listing')
// 					->where('id', $value->id)
// 					->update(['Revenue' => $Revenue, 'update_flag' => 1]);
// 			} else {

// 				DB::table('listing')
// 					->where('id', $value->id)
// 					->update(['Revenue' => $input_string_replace[0], 'update_flag' => 1]);
// 			}
// 		}
// 	}

// 	Mail::raw('Data Update Cron Of Data.bizprospex Runs End', function ($message) {
// 		$message->from('amir.s.lujayninfoways@gmail.com', 'Data Update Cron Of Data.bizprospex');
// 		$message->to('rajjak.lujayninfoways@gmail.com');
// 		$message->subject('Data.bizb2b Data Update Cron End run');
// 	});
// })->name('plans.index2');



//end 

Route::get('email/plain-text', function () {
	// Mail::raw('This is the content of mail body -plain-text', function($message) {
	//    $message -> from('amir.s.lujayninfoways@gmail.com', 'Cron Run Test From DataBizb2b');
	//    $message -> to('amir.s.lujayninfoways@gmail.com');
	//    $message -> subject('Data.bizb2b Cron Run');
	// });  
	dd('Send Email Successfully');
});


// Route::get('/send/email', "App\Http\Controllers\Web\EmailSent@sent");

// changes by rajjak(dec 16-19)

// Route::get('admin/listingFileName', [listingFileName::class, 'listingFileName'])->name('listingFileName');
// Route::get('admin/listingFileName/{id}', [listingFileName::class, 'fileDelete'])->name('fileDelete');
// Route::get('admin/listingFileName/download/{id}',[listingFileName::class, 'download'])->name('download');

// Route::get('admin/exportFile/download/{id}', [listingFileName::class, 'exportFile'])->name('exportFile');


// dec 26,2022
// Route::get('/countries', function () {
//     return redirect('/');
// });

// end
