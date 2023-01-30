<?php


namespace App\Http\Controllers\Web\Account\Traits;

use App\Helpers\UrlGen;
use App\Models\Thread;

trait MessagesTrait
{
	/**
	 * Check Threads with New Messages
	 *
	 * @return \Illuminate\Http\JsonResponse|void
	 */
	public function checkNew()
	{
		if (!request()->ajax()) {
			return;
		}
		
		$countLimit = 20;
		$countThreadsWithNewMessages = 0;
		$oldValue = request()->input('oldValue');
		$languageCode = request()->input('languageCode');
		
		if (auth()->check()) {
			$countThreadsWithNewMessages = Thread::whereHas('post', function ($query) {
				$query->currentCountry()->unarchived();
			})->forUserWithNewMessages(auth()->id())->count();
		}
		
		$result = [
			'logged'                      => (auth()->check()) ? auth()->user()->id : 0,
			'countLimit'                  => (int)$countLimit,
			'countThreadsWithNewMessages' => (int)$countThreadsWithNewMessages,
			'oldValue'                    => (int)$oldValue,
			'loginUrl'                    => UrlGen::login(),
		];
		
		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
	
	/* PRIVATE */
	
	/**
	 * @param $entryId
	 * @return array|mixed
	 */
	private function getSelectedIds($entryId)
	{
		$ids = [];
		if (request()->filled('entries')) {
			$ids = request()->input('entries');
		} else {
			if (!is_numeric($entryId) && $entryId <= 0) {
				$ids = [];
			} else {
				$ids[] = $entryId;
			}
		}
		$ids = !empty($ids) ? '/' . implode(',', $ids) : '';
		
		return $ids;
	}
}