<?php


namespace App\Helpers\Search\Traits\Filters;

use Illuminate\Support\Facades\DB;

trait DateFilter
{
	protected function applyDateFilter()
	{
		if (!(isset($this->posts) && isset($this->postsTable))) {
			return;
		}
		
		$postedDate = null;
		if (request()->filled('postedDate') && is_numeric(request()->get('postedDate'))) {
			$postedDate = request()->get('postedDate');
		}
		
		if (!empty($postedDate)) {
			$this->posts->whereRaw(DB::getTablePrefix() . $this->postsTable . '.created_at BETWEEN DATE_SUB(NOW(), INTERVAL ? DAY) AND NOW()', [$postedDate]);
		}
	}
}
