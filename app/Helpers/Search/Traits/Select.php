<?php


namespace App\Helpers\Search\Traits;

use Illuminate\Support\Facades\DB;

trait Select
{
	protected function setSelect()
	{
		if (!(isset($this->posts) && isset($this->postsTable))) {
			return;
		}
		
		// Default Select Columns
		$select = [
			$this->postsTable . '.id',
			'country_code',
			'category_id',
			'post_type_id',
			'title',
			$this->postsTable . '.price',
			'city_id',
			'featured',
			$this->postsTable . '.created_at',
			'reviewed',
			'verified_email',
			'verified_phone',
		];
		
		// Default GroupBy Columns
		$groupBy = [$this->postsTable . '.id'];
		
		// Merge Columns
		$this->select = array_merge($this->select, $select);
		$this->groupBy = array_merge($this->groupBy, $groupBy);
		
		// Add the Select Columns
		if (is_array($this->select) && count($this->select) > 0) {
			foreach ($this->select as $column) {
				$this->posts->addSelect($column);
			}
		}
		
		// If the MySQL strict mode is activated, ...
		// Append all the non-calculated fields available in the 'SELECT' in 'GROUP BY' to prevent error related to 'only_full_group_by'
		if (env('DB_MODE_STRICT')) {
			$this->groupBy = $this->select;
		}
		
		// Price conversion (For the Currency Exchange plugin)
		$this->posts->addSelect(DB::raw('(' . DB::getTablePrefix() . $this->postsTable . '.price * ?) AS calculatedPrice'));
		$this->posts->addBinding(config('selectedCurrency.rate', 1), 'select');
	}
}
