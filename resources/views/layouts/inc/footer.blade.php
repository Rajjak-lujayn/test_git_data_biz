<?php
if (
	config('settings.other.ios_app_url') ||
	config('settings.other.android_app_url') ||
	config('settings.social_link.facebook_page_url') ||
	config('settings.social_link.twitter_url') ||
	config('settings.social_link.google_plus_url') ||
	config('settings.social_link.linkedin_url') ||
	config('settings.social_link.pinterest_url') ||
	config('settings.social_link.instagram_url')
) {
	$colClass1 = 'col-lg-3 col-md-3 col-sm-3 col-6';
	$colClass2 = 'col-lg-3 col-md-3 col-sm-3 col-6';
	$colClass3 = 'col-lg-2 col-md-2 col-sm-2 col-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-12';
} else {
	$colClass1 = 'col-lg-4 col-md-4 col-sm-4 col-6';
	$colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-6';
	$colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-12';
}
?>
<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="row">
				
				@if (!config('settings.footer.hide_links'))
					<!--<div class="{{ $colClass1 }}">-->
					<!--	<div class="footer-col">-->
					<!--		<h4 class="footer-title">{{ t('about_us') }}</h4>-->
					<!--		<ul class="list-unstyled footer-nav">-->
					<!--		{{--	@if (isset($pages) and $pages->count() > 0)-->
					<!--				@foreach($pages as $page)-->
					<!--					<li>-->
					<!--						<?php
				// 	<!--							$linkTarget = '';-->
				// 	<!--							if ($page->target_blank == 1) {-->
				// 	<!--								$linkTarget = 'target="_blank"';-->
				// 	<!--							}-->
											?>-->
					<!--						@if (!empty($page->external_link))-->
					<!--							<a href="{!! $page->external_link !!}" rel="nofollow" {!! $linkTarget !!}> {{ $page->name }} </a>-->
					<!--						@else-->
					<!--							<a href="{{ \App\Helpers\UrlGen::page($page) }}" {!! $linkTarget !!}> {{ $page->name }} </a>-->
					<!--						@endif-->
					<!--					</li>-->
					<!--				@endforeach-->
					<!--			@endif --}}-->
					<!--		</ul>-->
					<!--	</div>-->
					<!--</div>-->
					
					<!--<div class="{{ $colClass2 }}">-->
					<!--	<div class="footer-col">-->
					<!--		<h4 class="footer-title">{{ t('Contact and Sitemap') }}</h4>-->
							<!--<ul class="list-unstyled footer-nav">
					<!--			<li><a href="{{ \App\Helpers\UrlGen::contact() }}"> {{ t('Contact') }} </a></li>-->
					<!--			<li><a href="{{ \App\Helpers\UrlGen::sitemap() }}"> {{ t('sitemap') }} </a></li>-->
					<!--			@if (isset($countries) && $countries->count() > 1)-->
					<!--				<li><a href="{{ \App\Helpers\UrlGen::countries() }}"> {{ t('countries') }} </a></li>-->
					<!--			@endif-->
					<!--		</ul>-->
					<!--	</div>-->
					<!--</div>-->
					
					<!--<div class="{{ $colClass3 }}">-->
					<!--	<div class="footer-col">-->
					<!--		<h4 class="footer-title">{{ t('My Account') }}</h4>-->
					<!--		<ul class="list-unstyled footer-nav">-->
					<!--			@if (!auth()->user())-->
					<!--				<li>-->
					<!--					@if (config('settings.security.login_open_in_modal'))-->
					<!--						<a href="#quickLogin" data-toggle="modal"> {{ t('log_in') }} </a>-->
					<!--					@else-->
					<!--						<a href="{{ \App\Helpers\UrlGen::login() }}"> {{ t('log_in') }} </a>-->
					<!--					@endif-->
					<!--				</li>-->
					<!--				<li><a href="{{ \App\Helpers\UrlGen::register() }}"> {{ t('register') }} </a></li>-->
					<!--			@else-->
					<!--				<li><a href="{{ url('account') }}"> {{ t('Personal Home') }} </a></li>-->
								<!--	<li><a href="{{ url('account/my-posts') }}"> {{ t('my_ads') }} </a></li>
					<!--				<li><a href="{{ url('account/favourite') }}"> {{ t('favourite_ads') }} </a></li>-->
					<!--			@endif-->
					<!--		</ul>-->
					<!--	</div>-->
					<!--</div>-->
					
				@endif
				
				<div class="col-xl-12">
					@if (!config('settings.footer.hide_payment_plugins_logos') and isset($paymentMethods) and $paymentMethods->count() > 0)
						<div class="text-center paymanet-method-logo">
							{{-- Payment Plugins --}}
							@foreach($paymentMethods as $paymentMethod)
								@if (file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png')))
									<img src="{{ url('images/' . $paymentMethod->name . '/payment.png') }}" alt="{{ $paymentMethod->display_name }}" title="{{ $paymentMethod->display_name }}">
								@endif
							@endforeach
						</div>
					@else
						@if (!config('settings.footer.hide_links'))
							<hr>
						@endif
					@endif
					
					<div class="copy-info text-center">
						© {{ date('Y') }} {{ config('settings.app.app_name') }}. {{ t('all_rights_reserved') }}.
						@if (!config('settings.footer.hide_powered_by'))
							@if (config('settings.footer.powered_by_info'))
								{{ t('Powered by') }} {!! config('settings.footer.powered_by_info') !!}
							@else
								{{ t('Powered by') }}.
							@endif
						@endif
					</div>
				</div>
			
			</div>
		</div>
	</div>
</footer>
