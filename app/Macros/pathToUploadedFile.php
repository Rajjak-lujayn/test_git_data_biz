<?php


namespace App\Macros;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Create an Laravel (Symfony) UploadedFile object from absolute path
 *
 * Usage: File::pathToUploadedFile($path);
 *
 * @param string $path
 * @param bool $test
 * @return UploadedFile|bool
 */
Filesystem::macro('pathToUploadedFile', function ($path, $test = true) {
	
	if (!Storage::exists($path)) {
		return false;
	}
	
	$path = Storage::path($path);
	
	$filesystem = new Filesystem();
	$name = $filesystem->name($path);
	$extension = $filesystem->extension($path);
	$originalName = $name . '.' . $extension;
	$mimeType = $filesystem->mimeType($path);
	$error = null;
	
	return new UploadedFile($path, $originalName, $mimeType, $error, $test);
	
});
