<?php


namespace App\Providers\AppService;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

trait SymlinkTrait
{
	/**
	 * Setup Storage Symlink
	 * Check the local storage symbolic link and Create it if does not exist.
	 */
	private function setupStorageSymlink()
	{
		$symlink = public_path('storage');
		
		try {
			if (!is_link($symlink)) {
				// Symbolic links on windows are created by symlink() which accept only absolute paths.
				// Relative paths on windows are not supported for symlinks: http://php.net/manual/en/function.symlink.php
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
					Artisan::call('storage:link');
				} else {
					symlink('../storage/app/public', './storage');
				}
			}
		} catch (\Exception $e) {
			$message = ($e->getMessage() != '') ? $e->getMessage() : 'Error with the PHP symlink() function';
			
			$docSymlink = 'http://data.bizprospex.com';
			$docDirExists = 'http://data.bizprospex.com';
			if (
				Str::contains($message, 'File exists')
				|| Str::contains($message, 'No such file or directory')
			) {
				$docSymlink = $docDirExists;
			}
			
			$message = $message . ' - Please <a href="' . $docSymlink . '" target="_blank">see this article</a> for more information.';
			
			flash($message)->error();
		}
	}
}
