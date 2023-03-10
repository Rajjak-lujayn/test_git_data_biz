<?php


namespace App\Http\Controllers\Api\Post;

use App\Events\PostWasVisited;
use App\Http\Controllers\Api\Post\Traits\ShowFieldValueTrait;
use App\Http\Resources\PostResource;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

trait ShowTrait
{
	use ShowFieldValueTrait;
	
	public function showPost($id)
	{
		if (auth('sanctum')->check()) {
			$user = auth('sanctum')->user();
			
			// Get post's details even if it's not activated, not reviewed or archived
			$cacheId = 'post.withoutGlobalScopes.with.city.pictures.' . $id . '.' . config('app.locale');
			$post = Cache::remember($cacheId, $this->cacheExpiration, function () use ($id) {
				return Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
					->withCountryFix()
					->where('id', $id)
					->with([
						'category'      => function ($builder) { $builder->with(['parent']); },
						'postType',
						'city',
						'pictures',
						'latestPayment' => function ($builder) { $builder->with(['package']); },
						'savedByLoggedUser',
					])
					->first();
			});
			
			// If the logged user is not an admin user...
			if (!auth('sanctum')->user()->can(Permission::getStaffPermissions())) {
				// Then don't get post that are not from the user
				if (!empty($post) && $post->user_id != $user->id) {
					$cacheId = 'post.with.city.pictures.' . $id . '.' . config('app.locale');
					$post = Cache::remember($cacheId, $this->cacheExpiration, function () use ($id) {
						return Post::withCountryFix()
							->unarchived()
							->where('id', $id)
							->with([
								'category'      => function ($builder) { $builder->with(['parent']); },
								'postType',
								'city',
								'pictures',
								'latestPayment' => function ($builder) { $builder->with(['package']); },
								'savedByLoggedUser',
							])
							->first();
					});
				}
			}
		} else {
			$cacheId = 'post.with.city.pictures.' . $id . '.' . config('app.locale');
			$post = Cache::remember($cacheId, $this->cacheExpiration, function () use ($id) {
				return Post::withCountryFix()
					->unarchived()
					->where('id', $id)
					->with([
						'category'      => function ($builder) { $builder->with(['parent']); },
						'postType',
						'city',
						'pictures',
						'latestPayment' => function ($builder) { $builder->with(['package']); },
						'savedByLoggedUser',
					])
					->first();
			});
		}
		// Preview Post after activation
		if (request()->filled('preview') && request()->get('preview') == 1) {
			// Get post's details even if it's not activated and reviewed
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->withCountryFix()
				->where('id', $id)
				->with([
					'category'      => function ($builder) { $builder->with(['parent']); },
					'postType',
					'city',
					'pictures',
					'latestPayment' => function ($builder) { $builder->with(['package']); },
					'savedByLoggedUser',
				])
				->first();
		}
		
		// Post not found
		if (empty($post) || empty($post->category) || empty($post->city)) {
			abort(404, t('Post not found'));
		}
		
		// Increment Post visits counter
		Event::dispatch(new PostWasVisited($post));
		
		$data = [];
		
		$data['success'] = true;
		$data['result'] = new PostResource($post);
		
		// Get Custom Fields
		$data['extra']['fields'] = $this->showFieldsValues($post->category->id, $post->id);
		
		return $this->apiResponse($data);
	}
}
