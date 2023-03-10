<?php


namespace App\Observers;

use App\Helpers\Files\Storage\StorageDisk;
use App\Models\Language;
use App\Models\Payment;
use App\Models\Picture;
use App\Models\Post;
use App\Models\PostValue;
use App\Models\SavedPost;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Thread;
use App\Notifications\PostActivated;
use App\Notifications\PostReviewed;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
	/**
	 * Listen to the Entry updating event.
	 *
	 * @param Post $post
	 * @return void
	 */
	public function updating(Post $post)
	{
		// Get the original object values
		$original = $post->getOriginal();
		
		if (config('settings.mail.confirmation') == 1) {
			try {
				// Post Email address or Phone was not verified
				if ($original['verified_email'] != 1 || $original['verified_phone'] != 1) {
					// Post was not approved (reviewed)
					if ($original['reviewed'] != 1) {
						if (config('settings.single.posts_review_activation') == 1) {
							if ($post->verified_email == 1 && $post->verified_phone == 1) {
								if ($post->reviewed == 1) {
									$post->notify(new PostReviewed($post));
								} else {
									$post->notify(new PostActivated($post));
								}
							}
						} else {
							if ($post->verified_email == 1 && $post->verified_phone == 1) {
								$post->notify(new PostReviewed($post));
							}
						}
					} else {
						// Post was approved (reviewed)
						if ($post->verified_email == 1 && $post->verified_phone == 1) {
							$post->notify(new PostReviewed($post));
						}
					}
				} else {
					// Post Email address or Phone was verified
					// Post was not approved (reviewed)
					if ($original['reviewed'] != 1) {
						if ($post->verified_email == 1 && $post->verified_phone == 1) {
							if ($post->reviewed == 1) {
								$post->notify(new PostReviewed($post));
							}
						}
					}
				}
			} catch (\Exception $e) {
				if (!isFromApi()) {
					flash($e->getMessage())->error();
				}
			}
		}
	}
	
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param Post $post
	 * @return void
	 */
	public function deleting(Post $post)
	{
		// Storage Disk Init.
		$disk = StorageDisk::getDisk();
		
		// Delete all the Post's Custom Fields Values
		$postValues = PostValue::where('post_id', $post->id)->get();
		if ($postValues->count() > 0) {
			foreach ($postValues as $postValue) {
				$postValue->delete();
			}
		}
		
		// Delete all Threads
		$messages = Thread::where('post_id', $post->id);
		if ($messages->count() > 0) {
			foreach ($messages->cursor() as $message) {
				$message->forceDelete();
			}
		}
		
		// Delete all Saved Posts
		$savedPosts = SavedPost::where('post_id', $post->id);
		if ($savedPosts->count() > 0) {
			foreach ($savedPosts->cursor() as $savedPost) {
				$savedPost->delete();
			}
		}
		
		// Delete all Pictures
		$pictures = Picture::where('post_id', $post->id);
		if ($pictures->count() > 0) {
			foreach ($pictures->cursor() as $picture) {
				$picture->delete();
			}
		}
		
		// Delete the Payment(s) of this Post
		$payments = Payment::withoutGlobalScope(StrictActiveScope::class)->where('post_id', $post->id)->get();
		if ($payments->count() > 0) {
			foreach ($payments as $payment) {
				$payment->delete();
			}
		}
		
		// Check Reviews plugin
		if (config('plugins.reviews.installed')) {
			try {
				// Delete the reviews of this Post
				$reviews = \extras\plugins\reviews\app\Models\Review::where('post_id', $post->id);
				if ($reviews->count() > 0) {
					foreach ($reviews->cursor() as $review) {
						$review->delete();
					}
				}
			} catch (\Exception $e) {
			}
		}
		
		// Remove the ad media folder
		if (!empty($post->country_code) && !empty($post->id)) {
			$directoryPath = 'files/' . strtolower($post->country_code) . '/' . $post->id;
			
			if ($disk->exists($directoryPath)) {
				$disk->deleteDirectory($directoryPath);
			}
		}
		
		// Removing Entries from the Cache
		$this->clearCache($post);
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param Post $post
	 * @return void
	 */
	public function saved(Post $post)
	{
		// Create a new email token if the post's email is marked as unverified
		if ($post->verified_email != 1) {
			if (empty($post->email_token)) {
				$post->email_token = md5(microtime() . mt_rand());
				$post->save();
			}
		}
		
		// Create a new phone token if the post's phone number is marked as unverified
		if ($post->verified_phone != 1) {
			if (empty($post->phone_token)) {
				$post->phone_token = mt_rand(100000, 999999);
				$post->save();
			}
		}
		
		// Removing Entries from the Cache
		$this->clearCache($post);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param Post $post
	 * @return void
	 */
	public function deleted(Post $post)
	{
		//...
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $post
	 */
	private function clearCache($post)
	{
		Cache::forget($post->country_code . '.sitemaps.posts.xml');
		
		Cache::forget($post->country_code . '.home.getPosts.sponsored');
		Cache::forget($post->country_code . '.home.getPosts.latest');
		
		Cache::forget('post.withoutGlobalScopes.with.city.pictures.' . $post->id);
		Cache::forget('post.with.city.pictures.' . $post->id);
		
		try {
			$languages = Language::withoutGlobalScopes([ActiveScope::class])->get(['abbr']);
		} catch (\Exception $e) {
			$languages = collect([]);
		}
		
		if ($languages->count() > 0) {
			foreach ($languages as $language) {
				Cache::forget('post.withoutGlobalScopes.with.city.pictures.' . $post->id . '.' . $language->abbr);
				Cache::forget('post.with.city.pictures.' . $post->id . '.' . $language->abbr);
				Cache::forget($post->country_code . '.count.posts.by.cat.' . $language->abbr);
			}
		}
		
		Cache::forget('posts.similar.category.' . $post->category_id . '.post.' . $post->id);
		Cache::forget('posts.similar.city.' . $post->city_id . '.post.' . $post->id);
	}
}
