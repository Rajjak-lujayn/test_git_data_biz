<?php


namespace App\Http\Requests;

class ResetPasswordRequest extends AuthRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = parent::rules();
		
		$rules['password'] = [
			'required',
			'min:' . config('larapen.core.passwordLength.min', 6),
			'max:' . config('larapen.core.passwordLength.max', 60),
			'confirmed',
		];
		
		return $rules;
	}
}
