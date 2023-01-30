<?php


namespace App\Http\Requests\Admin;

class ResetPasswordRequest extends Request
{
	/**
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'email'    => ['required'],
			'password' => [
				'required',
				'min:' . config('larapen.core.passwordLength.min', 6),
				'max:' . config('larapen.core.passwordLength.max', 60),
				'confirmed',
			],
		];
		
		// CAPTCHA
		$rules = $this->captchaRules($rules);
		
		return $rules;
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		$messages = [];
		
		return $messages;
	}
}
