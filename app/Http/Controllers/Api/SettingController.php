<?php


namespace App\Http\Controllers\Api;

/**
 * @group Settings
 */
class SettingController extends BaseController
{
	/**
	 * List settings
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$data = [
			'success' => true,
			'result'  => config('settings'),
		];
		
		return $this->apiResponse($data);
	}
	
	/**
	 * Get setting
	 *
	 * @param $key
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($key)
	{
		$settingKey = 'settings.' . $key;
		
		if (config()->has($settingKey)) {
			$data = [
				'success' => true,
				'result'  => config($settingKey),
			];
			
			return $this->apiResponse($data);
		} else {
			return $this->respondNotFound();
		}
	}
}
