<?php


namespace App\Helpers\UrlGen;

use App\Helpers\UrlGen;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait ClearFiltersTrait
{
	/**
	 * @param $cat
	 * @param null $city
	 * @return string
	 */
	public static function getCategoryFilterClearLink($cat, $city = null)
	{
		$out = '';
		if (
			request()->filled('c')
			|| request()->filled('sc')
			|| Str::contains(Route::currentRouteAction(), 'Search\CategoryController')
		) {
			$exceptArr = ['page', 'cf', 'minPrice', 'maxPrice'];
			if (isset($cat) && !empty($cat)) {
				if (isset($cat->parent) && !empty($cat->parent)) {
					$exceptArr[] = 'sc';
				} else {
					$exceptArr[] = 'c';
				}
			}
			$url = UrlGen::search([], $exceptArr);
			
			if (!empty($cat)) {
				if (Str::contains(Route::currentRouteAction(), 'Search\CategoryController')) {
					if (isset($cat->parent) && !empty($cat->parent)) {
						$url = UrlGen::category($cat->parent, null, $city);
					}
				}
			}
			
			$out = getFilterClearBtn($url);
		}
		
		return $out;
	}
	
	/**
	 * @param null $city
	 * @param null $cat
	 * @return string
	 */
	public static function getCityFilterClearLink($cat = null, $city = null)
	{
		$out = '';
		if (
			request()->filled('l')
			|| request()->filled('location')
			|| Str::contains(Route::currentRouteAction(), 'Search\CityController')
		) {
			$exceptArr = ['page', 'l', 'location', 'distance'];
			$url = UrlGen::search([], $exceptArr);
			
			if (!empty($city)) {
				if (Str::contains(Route::currentRouteAction(), 'Search\CityController')) {
					$url = UrlGen::city($city, null, $cat);
				}
			}
			
			$out = getFilterClearBtn($url);
		}
		
		return $out;
	}
	
	/**
	 * @param null $cat
	 * @param null $city
	 * @return string
	 */
	public static function getDateFilterClearLink($cat = null, $city = null)
	{
		$out = '';
		if (request()->filled('postedDate')) {
			$queryArr = [];
			if (!empty($cat) && isset($cat->id)) {
				if (isset($cat->parent) && !empty($cat->parent)) {
					$queryArr['c'] = $cat->parent->id;
					$queryArr['sc'] = $cat->id;
				} else {
					$queryArr['c'] = $cat->id;
				}
			}
			if (!empty($city) && isset($city->id)) {
				$queryArr['l'] = $city->id;
			}
		echo	$url = UrlGen::search($queryArr, ['page', 'postedDate']);
			$out = getFilterClearBtn($url);
		}
		
		return $out;
	}
	
	/**
	 * @param null $cat
	 * @param null $city
	 * @return string
	 */
	public static function getPriceFilterClearLink($cat = null, $city = null)
	{
		$out = '';
		if (request()->filled('minPrice') || request()->filled('maxPrice')) {
			$queryArr = [];
			if (!empty($cat) && isset($cat->id)) {
				if (isset($cat->parent) && !empty($cat->parent)) {
					$queryArr['c'] = $cat->parent->id;
					$queryArr['sc'] = $cat->id;
				} else {
					$queryArr['c'] = $cat->id;
				}
			}
			if (!empty($city) && isset($city->id)) {
				$queryArr['l'] = $city->id;
			}
			$url = UrlGen::search($queryArr, ['page', 'minPrice', 'maxPrice']);
			$out = getFilterClearBtn($url);
		}
		
		return $out;
	}
	
	/**
	 * @param null $cat
	 * @param null $city
	 * @return string
	 */
	public static function getTypeFilterClearLink($cat = null, $city = null)
	{
		$out = '';
		if (request()->filled('type')) {
			$queryArr = [];
			if (!empty($cat) && isset($cat->id)) {
				if (isset($cat->parent) && !empty($cat->parent)) {
					$queryArr['c'] = $cat->parent->id;
					$queryArr['sc'] = $cat->id;
				} else {
					$queryArr['c'] = $cat->id;
				}
			}
			if (!empty($city) && isset($city->id)) {
				$queryArr['l'] = $city->id;
			}
			$url = \App\Helpers\UrlGen::search($queryArr, ['page', 'type']);
			$out = getFilterClearBtn($url);
		}
		
		return $out;
	}
	
	/**
	 * @param $field
	 * @param null $cat
	 * @param null $city
	 * @return string
	 */
	public static function getCustomFieldFilterClearLink($field, $cat = null, $city = null)
	{
		$out = '';
		if (request()->filled($field)) {
			$queryArr = [];
			if (!empty($cat) && isset($cat->id)) {
				if (isset($cat->parent) && !empty($cat->parent)) {
					$queryArr['c'] = $cat->parent->id;
					$queryArr['sc'] = $cat->id;
				} else {
					$queryArr['c'] = $cat->id;
				}
			}
			if (!empty($city) && isset($city->id)) {
				$queryArr['l'] = $city->id;
			}
			$url = UrlGen::search($queryArr, ['page', $field]);
			$out = getFilterClearBtn($url);
		}
		
		return $out;
	}
}
