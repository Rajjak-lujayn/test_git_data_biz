<?php


namespace App\Http\Controllers\Api\Post\Traits;

use App\Models\CategoryField;

trait ShowFieldValueTrait
{
	/**
	 * Get Post's Custom Fields Values
	 *
	 * Note: Called when displaying the Post's details
	 *
	 * @param $catId
	 * @param $postId
	 * @return \Illuminate\Support\Collection
	 */
	public function showFieldsValues($catId, $postId)
	{
		// Get the Post's Custom Fields by its Parent Category
		$customFields = CategoryField::getFields($catId, $postId);
		
		// Get the Post's Custom Fields that have a value
		$postValues = [];
		if ($customFields->count() > 0) {
			foreach ($customFields as $key => $field) {
				if (!empty($field->default_value)) {
					$postValues[$key] = $field;
				}
			}
		}
		
		// Get Result's Data
		$data = [
			'success' => true,
			'result'  => $postValues,
		];
		
		return $this->apiResponse($data);
	}
}
