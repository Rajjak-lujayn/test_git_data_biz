{{--
 --}}
@extends('errors.layouts.master')

@section('title', t('Whoops'))

@section('search')
	@parent
	@include('errors.layouts.inc.search')
@endsection

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						
						<div class="error-page mt-5 mb-5 ml-0 mr-0 pt-5">
							<h1 class="headline text-center" style="font-size: 180px;">{{ t('Whoops') }}</h1>
							<div class="text-center mt-5">
								<h3 class="m-t-0 color-danger">
									<i class="fas fa-exclamation-triangle"></i> {{ t('Bad request') }}
								</h3>
								<p>{!! t('we_can_not_process_your_request_text.') !!}</p>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
