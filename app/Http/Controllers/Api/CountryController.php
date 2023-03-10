<?php


namespace App\Http\Controllers\Api;

use App\Http\Resources\CountryResource;
use App\Http\Resources\EntityCollection;
use App\Models\Country;

/**
 * @group Countries
 */
class CountryController extends BaseController
{
	/**
	 * List countries
	 *
	 * @queryParam embed string Comma-separated list of the country relationships for Eager Loading. Possible values: currency
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$countries = Country::query();
		
		$embed = explode(',', request()->get('embed'));
		
		if (in_array('currency', $embed)) {
			$countries->with('currency');
		}
		
		$countries = $countries->paginate($this->perPage);
		
		$resourceCollection = new EntityCollection(class_basename($this), $countries);
		
		return $this->respondWithCollection($resourceCollection);
	}
	
	/**
	 * Get country
	 *
	 * @queryParam embed string Comma-separated list of the country relationships for Eager Loading. Possible values: currency
	 *
	 * @urlParam code string The country's ISO 3166-1 code. Example: DE
	 *
	 * @param $code
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($code)
	{
		$country = Country::query()->where('code', $code);
		
		$embed = explode(',', request()->get('embed'));
		
		if (in_array('currency', $embed)) {
			$country->with('currency');
		}
		
		$country = $country->firstOrFail();
		
		$resource = new CountryResource($country);
		
		return $this->respondWithResource($resource);
	}
}
