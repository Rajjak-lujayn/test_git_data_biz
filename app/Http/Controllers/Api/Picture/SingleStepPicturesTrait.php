<?php


namespace App\Http\Controllers\Api\Picture;

use App\Http\Requests\Request;
use App\Models\Picture;

trait SingleStepPicturesTrait
{
	/**
	 * @param $postId
	 * @param \App\Http\Requests\Request $request
	 * @return array
	 * @throws \Exception
	 */
	public function storeSingleStepPictures($postId, Request $request)
	{
		$pictures = [];
		
		// Get normal files uploaded
		$files = (array)$request->file('pictures');
		
		// If files not found, get manually added files uploaded
		if (is_array($files) && count($files) <= 0) {
			$files = (array)$request->files->get('pictures');
		}
		
		// Save all pictures
		if (is_array($files) && count($files) > 0) {
			$i = 0;
			foreach ($files as $key => $file) {
				if (empty($file)) {
					continue;
				}
				
				$picturePosition = $i;
				if (in_array($request->method(), ['PUT', 'PATCH', 'UPDATE'])) {
					// Delete old file if new file has uploaded
					// Check if current Post have a pictures
					$possiblePictures = Picture::query()->where('post_id', $postId)->where('id', $key);
					if ($possiblePictures->count() > 0) {
						$picture = $possiblePictures->first();
						$picturePosition = $picture->position;
						$picture->delete();
					}
				}
				
				// Save Post's Picture in DB
				$picture = new Picture([
					'post_id'  => $postId,
					'filename' => $file,
					'position' => $picturePosition,
				]);
				if (isset($picture->filename) && !empty($picture->filename)) {
					$picture->save();
				}
				
				$pictures[] = $picture;
				
				$i++;
			}
		}
		
		return $pictures;
	}
}
