{{--
 --}}
 <?php //phpinfo(); ?>
@extends('layouts.master')

@section('search')
	@parent
@endsection

@section('content')
	<div class="main-container" id="homepage">
		
		@if (session()->has('flash_notification'))
			@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
			<?php $paddingTopExists = true; ?>
			<div class="container">
				<div class="row">
					<div class="col-xl-12">
						@include('flash::message')
					</div>
				</div>
			</div>
		@endif
			
		@if (isset($sections) and $sections->count() > 0)
			@foreach($sections as $section)
				@if (view()->exists($section->view))
					@includeFirst([config('larapen.core.customizedViewPath') . $section->view, $section->view], ['firstSection' => $loop->first])
				@endif
			@endforeach
		@endif
		
	</div>
@endsection

@section('after_scripts')
	<script>
		@if (config('settings.optimization.lazy_loading_activation') == 1)
		$(document).ready(function () {
			$('#postsList').each(function () {
				var $masonry = $(this);
				var update = function () {
					$.fn.matchHeight._update();
				};
				$('.item-list', $masonry).matchHeight();
				this.addEventListener('load', update, true);
			});
		});
		@endif
	</script>
@endsection
