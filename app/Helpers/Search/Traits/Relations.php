<?php


namespace App\Helpers\Search\Traits;

use App\Helpers\Search\Traits\Relations\CategoryRelation;
use App\Helpers\Search\Traits\Relations\PaymentRelation;

trait Relations
{
	use CategoryRelation, PaymentRelation;
	
	protected function setRelations()
	{
		if (!isset($this->posts)) {
			dd('Fatal Error: Search relations cannot be applied.');
		}
		
		// category
		$this->setCategoryRelation();
		
		// postType
		$this->posts->with('postType');
		
		// latestPayment
		$this->setPaymentRelation();
		
		// city
		$this->posts->with('city')->has('city');
		
		// pictures
		$this->posts->with('pictures');
		
		// savedByLoggedUser
		$this->posts->with('savedByLoggedUser');
	}
}
