<?php


namespace App\Helpers\Search\Traits\Filters;

trait PriceFilter
{
	protected function applyPriceFilter()
	{
		if (!isset($this->having)) {
			return;
		}
		
		$minPrice = null;
		if (request()->filled('minPrice') && is_numeric(request()->get('minPrice'))) {
			$minPrice = request()->get('minPrice');
		}
		
		$maxPrice = null;
		if (request()->filled('maxPrice') && is_numeric(request()->get('maxPrice'))) {
			$maxPrice = request()->get('maxPrice');
		}
		
		if (!empty($minPrice) && !empty($maxPrice)) {
			if ($maxPrice > $minPrice) {
				$this->having[] = 'calculatedPrice >= ' . $minPrice;
				$this->having[] = 'calculatedPrice <= ' . $maxPrice;
			}
		} else {
			if (!empty($minPrice)) {
				$this->having[] = 'calculatedPrice >= ' . $minPrice;
			}
			
			if (!empty($maxPrice)) {
				$this->having[] = 'calculatedPrice <= ' . $maxPrice;
			}
		}
	}
}
