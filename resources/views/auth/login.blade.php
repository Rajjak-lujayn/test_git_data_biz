{{--
 --}}
@extends('layouts.master')

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div class="main-container">
		<div class="container">
			<div class="login-wrapper">

				@if (isset($errors) and $errors->any())
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (session()->has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				@if (
					config('settings.social_auth.social_login_activation')
					and (
						(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
						or (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
						or (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
						or (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
						)
					)
					<div class="col-xl-12">
						<div class="row d-flex justify-content-center">
							<div class="col-8">
								<div class="row mb-3 d-flex justify-content-center pl-3 pr-3">
									@if (config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-fb">
											<a href="{{ url('auth/facebook') }}" class="btn-fb"><i class="icon-facebook-rect"></i> {!! t('Login with Facebook') !!}</a>
										</div>
									</div>
									@endif
									@if (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-lkin">
											<a href="{{ url('auth/linkedin') }}" class="btn-lkin"><i class="icon-linkedin"></i> {!! t('Login with LinkedIn') !!}</a>
										</div>
									</div>
									@endif
									@if (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-tw">
											<a href="{{ url('auth/twitter') }}" class="btn-tw"><i class="icon-twitter-bird"></i> {!! t('Login with Twitter') !!}</a>
										</div>
									</div>
									@endif
									@if (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-danger">
											<a href="{{ url('auth/google') }}" class="btn-danger"><i class="icon-googleplus-rect"></i> {!! t('Login with Google') !!}</a>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				@endif
					
				<div class="col-lg-5 col-md-8 col-sm-10 col-12 login-box mt-3">
					<form id="loginForm" role="form" method="POST" action="{{ url()->current() }}">
						{!! csrf_field() !!}
						<input type="hidden" name="country" value="{{ config('country.code') }}">
						<div class="card card-default">
							
							<div class="panel-intro text-center">
								<h2 class="logo-title"><strong>{{ t('log_in') }}</strong></h2>
							</div>
							
							<div class="card-body">
								<?php
									$loginValue = (session()->has('login')) ? session('login') : old('login');
									$loginField = getLoginField($loginValue);
									if ($loginField == 'phone') {
										$loginValue = phoneFormat($loginValue, old('country', config('country.code')));
									}
								?>
								<!-- login -->
								<?php $loginError = (isset($errors) and $errors->has('login')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="login" class="col-form-label">{{ t('login') . ' (' . getLoginLabel() . ')' }}:</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-user fa"></i></span>
										</div>
										<input id="login" name="login" type="text" placeholder="{{ getLoginLabel() }}" class="form-control{{ $loginError }}" value="{{ $loginValue }}">
									</div>
								</div>
								
								<!-- password -->
								<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="password" class="col-form-label">{{ t('password') }}:</label>
									<div class="input-group show-pwd-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-lock fa"></i></span>
										</div>
										<input id="password" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="{{ t('password') }}" autocomplete="off">
										<span class="icon-append show-pwd">
											<button type="button" class="eyeOfPwd">
												<i class="far fa-eye-slash"></i>
											</button>
										</span>
									</div>
								</div>
								
								@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.captcha', 'layouts.inc.tools.captcha'], ['noLabel' => true])
								
								<!-- Submit -->
								<div class="form-group">
									<button id="loginBtn" class="btn btn-primary btn-block"> {{ t('log_in') }} </button>
								</div>
							</div>
							
							<div class="card-footer">
								<label class="checkbox pull-left mt-2 mb-2">
									<input type="checkbox" value="1" name="remember" id="remember">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description"> {{ t('keep_me_logged_in') }}</span>
								</label>
								<div class="text-center pull-right mt-2 mb-2">
									<a href="{{ url('password/reset') }}"> {{ t('lost_your_password') }} </a>
								</div>
								<div style=" clear:both"></div>
							</div>
						</div>
					</form>

					<div class="login-box-btm text-center">
						<p>
							{{ t('do_not_have_an_account') }}<br>
							<a href="{{ \App\Helpers\UrlGen::register() }}"><strong>{{ t('sign_up') }} !</strong></a>
						</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script>
		$(document).ready(function () {
			$("#loginBtn").click(function () {
				$("#loginForm").submit();
				return false;
			});
		});
	</script>
@endsection
