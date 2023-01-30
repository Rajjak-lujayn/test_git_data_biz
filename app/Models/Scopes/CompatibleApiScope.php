<?php


namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CompatibleApiScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 *
	 * @param Builder $builder
	 * @param Model $model
	 * @return $this|Builder
	 */
	public function apply(Builder $builder, Model $model)
	{
		// Load only the API Compatible entries for API call
		if (isFromApi()) {
			if (request()->header('X-AppType') != 'web') {
				$builder->where('is_compatible_api', 1);
			}
		}
		
		// Load all entries for Web call
		return $builder;
	}
}
