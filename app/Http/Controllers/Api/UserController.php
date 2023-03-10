<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Api\User\Delete;
use App\Http\Controllers\Api\User\Update\Photo;
use App\Http\Controllers\Api\User\Register;
use App\Http\Controllers\Api\User\Update;
use App\Http\Requests\UserRequest;
use App\Http\Resources\EntityCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

/**
 * @group Users
 */
class UserController extends BaseController
{
	use Register, Update, VerificationTrait, Photo, Delete;
	
	/**
	 * List users
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		/*
		$users = User::paginate($this->perPage);
		$resourceCollection = new EntityCollection(class_basename($this), $users);
		
		return $this->respondWithCollection($resourceCollection);
		*/
		
		return $this->respondUnAuthorized();
	}
	
	/**
	 * Store user
	 *
	 * @bodyParam country_code string required The code of the user's country. Example: US
	 * @bodyParam language_code string The code of the user's spoken language. Example: en
	 * @bodyParam user_type_id int The ID of user type. Example: 1
	 * @bodyParam gender_id int The ID of gender. Example: 1
	 * @bodyParam name string required The name of the user. Example: John Doe
	 * @bodyParam photo file The file of user photo.
	 * @bodyParam phone string The mobile phone number of the user (required if email doesn't exist). Example: +17656766467
	 * @bodyParam phone_hidden boolean Field to hide or show the user phone number in public. Example: 0
	 * @bodyParam email string The user's email address (required if mobile phone number doesn't exist). Example: john.doe@domain.tld
	 * @bodyParam username string The user's username. Example: john_doe
	 * @bodyParam password string required The user's password. Example: js!X07$z61hLA
	 * @bodyParam password_confirmation string required The confirmation of the user's password. Example: js!X07$z61hLA
	 * @bodyParam disable_comments boolean Field to disable or enable comments on the user's posts. Example: 1
	 * @bodyParam ip_addr string required The user's IP address.
	 * @bodyParam accept_terms boolean required Field to allow user to accept or not the website terms. Example: 1
	 * @bodyParam accept_marketing_offers boolean Field to allow user to accept or not marketing offers sending. Example: 0
	 * @bodyParam time_zone string The user's time zone. Example: America/New_York
	 * @bodyParam captcha_key string Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
	 *
	 * @param UserRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(UserRequest $request)
	{
		return $this->register($request);
	}
	
	/**
	 * Get user
	 *
	 * @authenticated
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($id)
	{
		$user = User::query()->verified()->findOrFail($id);
		$resource = new UserResource($user);
		
		return $this->respondWithResource($resource);
	}
	
	/**
	 * Update user
	 *
	 * @authenticated
	 * @header Authorization Bearer {YOUR_AUTH_TOKEN}
	 *
	 * @bodyParam country_code string required The code of the user's country. Example: US
	 * @bodyParam language_code string The code of the user's spoken language. Example: en
	 * @bodyParam user_type_id int The ID of user type. Example: 1
	 * @bodyParam gender_id int The ID of gender. Example: 1
	 * @bodyParam name string required The name of the user. Example: John Doe
	 * @bodyParam photo file The file of user photo.
	 * @bodyParam phone string The mobile phone number of the user (required if email doesn't exist). Example: +17656766467
	 * @bodyParam phone_hidden boolean Field to hide or show the user phone number in public. Example: 0
	 * @bodyParam email string required The user's email address. Example: john.doe@domain.tld
	 * @bodyParam username string The user's username. Example: john_doe
	 * @bodyParam password string required The user's password. Example: js!X07$z61hLA
	 * @bodyParam password_confirmation string required The confirmation of the user's password. Example: js!X07$z61hLA
	 * @bodyParam disable_comments boolean Field to disable or enable comments on the user's posts. Example: 1
	 * @bodyParam ip_addr string required The user's IP address.
	 * @bodyParam accept_terms boolean required Field to allow user to accept or not the website terms. Example: 1
	 * @bodyParam accept_marketing_offers boolean Field to allow user to accept or not marketing offers sending. Example: 0
	 * @bodyParam time_zone string The user's time zone. Example: America/New_York
	 *
	 * @param $id
	 * @param \App\Http\Requests\UserRequest $request
	 * @return mixed
	 */
	public function update($id, UserRequest $request)
	{
		return $this->updateDetails($id, $request);
	}
	
	/**
	 * Delete user
	 *
	 * @authenticated
	 * @header Authorization Bearer {YOUR_AUTH_TOKEN}
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($id)
	{
		return $this->closeAccount($id);
	}
}
