{{--
 --}}
@extends('layouts.master')

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div class="main-container">
		<div class="container">
			<div class="row">
				
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
				
				@if (session()->has('status'))
					<div class="col-xl-12">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('status') }}</p>
						</div>
					</div>
				@endif
				
				@if (session()->has('email'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('email') }}</p>
						</div>
					</div>
				@endif
				
				@if (session()->has('phone'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('phone') }}</p>
						</div>
					</div>
				@endif
				
				@if (session()->has('login'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('login') }}</p>
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

				<div class="col-lg-5 col-md-8 col-sm-10 col-12 login-box">
					<div class="card card-default">
						<div class="panel-intro text-center">
							<h2 class="logo-title">{{ t('password') }}</h2>
						</div>
						
						<div class="card-body">
							<form id="pwdForm" role="form" method="POST" action="{{ url('password/email') }}">
								{!! csrf_field() !!}
								
								<!-- login -->
								<?php $loginError = (isset($errors) and $errors->has('login')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="login" class="col-form-label">{{ t('login') . ' (' . getLoginLabel() . ')' }}:</label>
									<div class="input-icon">
										<i class="icon-user fa"></i>
										<input id="login"
											   name="login"
											   type="text"
											   placeholder="{{ getLoginLabel() }}"
											   class="form-control{{ $loginError }}"
											   value="{{ old('login') }}"
										>
									</div>
								</div>
								
								@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.captcha', 'layouts.inc.tools.captcha'], ['noLabel' => true])
								
								<!-- Submit -->
								<div class="form-group">
									<button id="pwdBtn" type="submit" class="btn btn-primary btn-lg btn-block">{{ t('submit') }}</button>
								</div>
							</form>
						</div>
						
						<div class="card-footer text-center">
							<a href="{{ \App\Helpers\UrlGen::login() }}"> {{ t('back_to_the_log_in_page') }} </a>
						</div>
					</div>
					<div class="login-box-btm text-center">
						<p>
							{{ t('do_not_have_an_account') }} <br>
							<a href="{{ \App\Helpers\UrlGen::register() }}"><strong>{{ t('sign_up_') }}</strong></a>
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
			$("#pwdBtn").click(function () {
				$("#pwdForm").submit();
				return false;
			});
		});
	</script>
@endsection