<?php


namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Larapen\Admin\app\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
	/**
	 * ResetPasswordController constructor.
	 */
	public function __construct()
	{
		$this->middleware('guest');
		
		parent::__construct();
	}
	
	// -------------------------------------------------------
	// Laravel overwrites for loading admin views
	// -------------------------------------------------------
	
	/**
	 * Display the password reset view for the given token.
	 *
	 * If no token is present, display the link request form.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param null $token
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function showResetForm(Request $request, $token = null)
	{
		return view('admin::auth.passwords.reset', ['title' => trans('admin.reset_password')])->with([
			'token' => $token,
			'email' => $request->email,
		]);
	}
}
