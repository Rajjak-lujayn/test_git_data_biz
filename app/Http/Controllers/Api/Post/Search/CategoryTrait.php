<?php


namespace App\Http\Controllers\Api\Post\Search;

use App\Http\Controllers\Api\Category\CategoryBySlug;

trait CategoryTrait
{
	use CategoryBySlug;
	
	/**
	 * Get Category (Auto-detecting ID or Slug)
	 *
	 * @return mixed|null
	 */
	public function getCategory()
	{
		$cat = null;
		
		// Get the Category's right arguments
		$catParentId = null;
		$catId = null;
		if (request()->filled('c')) {
			$catId = request()->get('c');
			if (request()->filled('sc')) {
				$catParentId = $catId;
				$catId = request()->get('sc');
			}
		}
		
		// Get the Category
		if (!empty($catId)) {
			if (is_numeric($catId)) {
				$cat = $this->getCategoryById($catId);
			} else {
				if (empty($catParentId) || (!empty($catParentId) && !is_numeric($catParentId))) {
					$cat = $this->getCategoryBySlug($catId, $catParentId);
				}
			}
			
			if (empty($cat)) {
				abort(404, t('category_not_found'));
			}
		}
		
		return $cat;
	}
}
