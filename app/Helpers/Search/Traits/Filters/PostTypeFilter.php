<?php


namespace App\Helpers\Search\Traits\Filters;

use App\Models\PostType;
use Illuminate\Support\Facades\Cache;

trait PostTypeFilter
{
	protected function applyPostTypeFilter()
	{
		if (config('settings.single.show_post_types') != '1') {
			return;
		}
		
		if (!isset($this->posts)) {
			return;
		}
		
		$postTypeId = null;
		if (request()->filled('type')) {
			$postTypeId = request()->get('type');
		}
		
		if (!empty($postTypeId)) {
			if (!$this->checkIfPostTypeExists($postTypeId)) {
				abort(404, t('The requested ad type does not exist'));
			}
			
			$this->posts->where('post_type_id', $postTypeId);
		}
	}
	
	/**
	 * Check if PostType exist(s)
	 *
	 * @param $postTypeId
	 * @return bool
	 */
	private function checkIfPostTypeExists($postTypeId)
	{
		$found = false;
		
		// If Ad Type is filled, then check if the Ad Type exists
		if (!empty($postTypeId)) {
			$cacheId = 'search.postType.' . $postTypeId . '.' . config('app.locale');
			$postType = Cache::remember($cacheId, self::$cacheExpiration, function () use ($postTypeId) {
				return PostType::where('id', $postTypeId)->first(['id']);
			});
			
			if (!empty($postType)) {
				$found = true;
			}
		} else {
			$found = true;
		}
		
		return $found;
	}
}
