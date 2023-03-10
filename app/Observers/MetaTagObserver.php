<?php


namespace App\Observers;

use App\Models\MetaTag;
use Illuminate\Support\Facades\Cache;

class MetaTagObserver
{
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param MetaTag $metaTag
	 * @return void
	 */
	public function saved(MetaTag $metaTag)
	{
		// Removing Entries from the Cache
		$this->clearCache($metaTag);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param MetaTag $metaTag
	 * @return void
	 */
	public function deleted(MetaTag $metaTag)
	{
		// Removing Entries from the Cache
		$this->clearCache($metaTag);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $metaTag
	 */
	private function clearCache($metaTag)
	{
		Cache::flush();
	}
}
