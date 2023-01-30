<?php


namespace App\Http\Controllers\Api;

use App\Models\Package;
use App\Http\Resources\EntityCollection;
use App\Http\Resources\PackageResource;

/**
 * @group Packages
 */
class PackageController extends BaseController
{
	/**
	 * List packages
	 *
	 * @queryParam embed string Comma-separated list of the package relationships for Eager Loading. Example: currency
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$packages = Package::query()->applyCurrency();
		
		$embed = explode(',', request()->get('embed'));
		
		if (in_array('currency', $embed)) {
			$packages->with('currency');
		}
		
		$packages->orderBy('lft');
		
		$packages = $packages->get();
		
		$resourceCollection = new EntityCollection(class_basename($this), $packages);
		
		return $this->respondWithCollection($resourceCollection);
	}
	
	/**
	 * Get package
	 *
	 * @queryParam embed string Comma-separated list of the package relationships for Eager Loading. Example: currency
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($id)
	{
		$package = Package::query()->where('id', $id);
		
		$embed = explode(',', request()->get('embed'));
		
		if (in_array('currency', $embed)) {
			$package->with('currency');
		}
		
		$package = $package->firstOrFail($id);
		
		if (!empty($package)) {
			$package->setLocale(config('app.locale'));
		}
		
		$resource = new PackageResource($package);
		
		return $this->respondWithResource($resource);
	}
}
