<?php


namespace App\Http\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\PostResource;
use App\Models\Permission;
use App\Models\Post;
use App\Models\User;
use App\Notifications\FormSent;
use App\Notifications\ReportSent;
use Illuminate\Support\Facades\Notification;

/**
 * @group Contact
 */
class ContactController extends BaseController
{
	/**
	 * Send Form
	 *
	 * Send a message to the site owner.
	 *
	 * @bodyParam country_code string required The user's country code. Example: US
	 * @bodyParam country_name string required The user's country name. Example: United Sates
	 * @bodyParam first_name string required The user's first name. Example: John
	 * @bodyParam last_name string required The user's last name. Example: Doe
	 * @bodyParam email string required The user's email address. Example: john.doe@domain.tld
	 * @bodyParam message string required The message to send. Example: Nesciunt porro possimus maiores voluptatibus accusamus velit qui aspernatur.
	 * @bodyParam captcha_key string Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
	 *
	 * @param \App\Http\Requests\ContactRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sendForm(ContactRequest $request)
	{
		// Store Contact Input
		$contactForm = $request->all();
		$contactForm = ArrayHelper::toObject($contactForm);
		
		// Send Contact Email
		try {
			if (config('settings.app.email')) {
				Notification::route('mail', config('settings.app.email'))->notify(new FormSent($contactForm));
			} else {
				$admins = User::where('is_admin', 1)->get();
				if ($admins->count() > 0) {
					Notification::send($admins, new FormSent($contactForm));
				}
			}
			
			$data = [
				'success' => true,
				'message' => t('message_sent_to_moderators_thanks'),
				'result'  => $contactForm,
			];
			
			return $this->apiResponse($data);
		} catch (\Exception $e) {
			return $this->respondError($e->getMessage());
		}
	}
	
	/**
	 * Report post
	 *
	 * Report abuse or issues
	 *
	 * @bodyParam report_type_id int required The report type ID. Example: 2
	 * @bodyParam email string required The user's email address. Example: john.doe@domain.tld
	 * @bodyParam message string required The message to send. Example: Et sunt voluptatibus ducimus id assumenda sint.
	 * @bodyParam captcha_key string Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
	 *
	 * @urlParam id int required The post ID.
	 *
	 * @param $postId
	 * @param ReportRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sendReport($postId, ReportRequest $request)
	{
		// Get Post
		$post = Post::findOrFail($postId);
		
		// Store Report Input
		$report = $request->all();
		$report = ArrayHelper::toObject($report);
		
		// Send Abuse Report to admin
		try {
			if (config('settings.app.email')) {
				Notification::route('mail', config('settings.app.email'))->notify(new ReportSent($post, $report));
			} else {
				$admins = User::permission(Permission::getStaffPermissions())->get();
				if ($admins->count() > 0) {
					Notification::send($admins, new ReportSent($post, $report));
				}
			}
			
			$data = [
				'success' => true,
				'message' => t('report_has_sent_successfully_to_us'),
				'result'  => $report,
				'extra'   => [
					'post' => (new PostResource($post))->toArray($request),
				],
			];
			
			return $this->apiResponse($data);
		} catch (\Exception $e) {
			return $this->respondError($e->getMessage());
		}
	}
}
