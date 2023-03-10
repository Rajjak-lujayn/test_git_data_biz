<?php


namespace App\Models\Post;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Larapen\LaravelDistance\Distance;

trait SimilarByLocation
{
	/**
	 * Get Posts in the same Location
	 *
	 * @param $distance
	 * @param int $limit
	 * @return \Illuminate\Support\Collection
	 */
	public function getSimilarByLocation($distance, $limit = 20)
	{
		$posts = Post::query();
		
		$tablesPrefix = DB::getTablePrefix();
		$postsTable = (new Post())->getTable();
		
		if (!is_numeric($distance) || $distance < 0) {
			$distance = 0;
		}
		
		$select = [
			$postsTable . '.id',
			$postsTable . '.country_code',
			'category_id',
			'title',
			$postsTable . '.price',
			'featured',
			'reviewed',
			'verified_email',
			'verified_phone',
			$postsTable . '.created_at',
			$postsTable . '.archived_at',
		];
		
		$having = [];
		$orderBy = [];
		
		if (is_array($select) && count($select) > 0) {
			foreach ($select as $column) {
				$posts->addSelect($column);
			}
		}
		
		// Default Filters
		$posts->currentCountry()->verified()->unarchived();
		if (config('settings.single.posts_review_activation')) {
			$posts->reviewed();
		}
		
		// Use the Cities Extended Searches
		config()->set('distance.functions.default', config('settings.listing.distance_calculation_formula'));
		config()->set('distance.countryCode', config('country.code'));
		
		if (isset($this->city) && !empty($this->city)) {
			if (config('settings.listing.cities_extended_searches')) {
				
				// Use the Cities Extended Searches
				config()->set('distance.functions.default', config('settings.listing.distance_calculation_formula'));
				config()->set('distance.countryCode', config('country.code'));
				
				$sql = Distance::select('lon', 'lat', $this->city->longitude, $this->city->latitude);
				if ($sql) {
					$posts->addSelect(DB::raw($sql));
					$having[] = Distance::having($distance);
					$orderBy[] = Distance::orderBy('ASC');
				} else {
					$posts->where('city_id', $this->city->id);
				}
				
			} else {
				
				// Use the Cities Standard Searches
				$posts->where('city_id', $this->city->id);
				
			}
		}
		
		// Relations
		$posts->with('category')->has('category');
		$posts->with('pictures');
		$posts->with('city')->has('city');
		
		if (isset($this->id)) {
			$posts->where($postsTable . '.id', '!=', $this->id);
		}
		
		// Set HAVING
		$havingStr = '';
		if (is_array($having) && count($having) > 0) {
			foreach ($having as $key => $value) {
				if (trim($value) == '') {
					continue;
				}
				if (Str::contains($value, '.')) {
					$value = $tablesPrefix . $value;
				}
				
				if ($havingStr == '') {
					$havingStr .= $value;
				} else {
					$havingStr .= ' AND ' . $value;
				}
			}
			if (!empty($havingStr)) {
				$posts->havingRaw($havingStr);
			}
		}
		
		// Set ORDER BY
		$orderBy[] = $tablesPrefix . $postsTable . '.created_at DESC';
		$posts->orderByRaw(implode(', ', $orderBy));
		
		$posts = $posts->take((int)$limit)->get();
		
		// Randomize the Posts
		$posts = collect($posts)->shuffle();
		
		return $posts;
	}
}
