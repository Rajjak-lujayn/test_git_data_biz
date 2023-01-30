<?php
// Init.
$sForm = [
	'enableFormAreaCustomization' => '0',
	'hideTitles'                  => '0',
	'title'                       => t('sell_and_buy_near_you'),
	'subTitle'                    => t('simple_fast_and_efficient'),
	'bigTitleColor'               => '', // 'color: #FFF;',
	'subTitleColor'               => '', // 'color: #FFF;',
	'backgroundColor'             => '', // 'background-color: #444;',
	'backgroundImage'             => '', // null,
	'height'                      => '', // '450px',
	'parallax'                    => '0',
	'hideForm'                    => '0',
	'formBorderColor'             => '', // 'background-color: #333;',
	'formBorderSize'              => '', // '5px',
	'formBtnBackgroundColor'      => '', // 'background-color: #4682B4; border-color: #4682B4;',
	'formBtnTextColor'            => '', // 'color: #FFF;',
];

// Get Search Form Options
if (isset($searchFormOptions)) {
	if (isset($searchFormOptions['enable_form_area_customization']) and !empty($searchFormOptions['enable_form_area_customization'])) {
		$sForm['enableFormAreaCustomization'] = $searchFormOptions['enable_form_area_customization'];
	}
	if (isset($searchFormOptions['hide_titles']) and !empty($searchFormOptions['hide_titles'])) {
		$sForm['hideTitles'] = $searchFormOptions['hide_titles'];
	}
	if (isset($searchFormOptions['title_' . config('app.locale')]) and !empty($searchFormOptions['title_' . config('app.locale')])) {
		$sForm['title'] = $searchFormOptions['title_' . config('app.locale')];
		$sForm['title'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['title']);
		if (\Illuminate\Support\Str::contains($sForm['title'], '{count_ads}')) {
			try {
				$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
			} catch (\Exception $e) {
				$countPosts = 0;
			}
			$sForm['title'] = str_replace('{count_ads}', $countPosts, $sForm['title']);
		}
		if (\Illuminate\Support\Str::contains($sForm['title'], '{count_users}')) {
			try {
				$countUsers = \App\Models\User::count();
			} catch (\Exception $e) {
				$countUsers = 0;
			}
			$sForm['title'] = str_replace('{count_users}', $countUsers, $sForm['title']);
		}
	}
	if (isset($searchFormOptions['sub_title_' . config('app.locale')]) and !empty($searchFormOptions['sub_title_' . config('app.locale')])) {
		$sForm['subTitle'] = $searchFormOptions['sub_title_' . config('app.locale')];
		$sForm['subTitle'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['subTitle']);
		if (\Illuminate\Support\Str::contains($sForm['subTitle'], '{count_ads}')) {
			try {
				$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
			} catch (\Exception $e) {
				$countPosts = 0;
			}
			$sForm['subTitle'] = str_replace('{count_ads}', $countPosts, $sForm['subTitle']);
		}
		if (\Illuminate\Support\Str::contains($sForm['subTitle'], '{count_users}')) {
			try {
				$countUsers = \App\Models\User::count();
			} catch (\Exception $e) {
				$countUsers = 0;
			}
			$sForm['subTitle'] = str_replace('{count_users}', $countUsers, $sForm['subTitle']);
		}
	}
	if (isset($searchFormOptions['parallax']) and !empty($searchFormOptions['parallax'])) {
		$sForm['parallax'] = $searchFormOptions['parallax'];
	}
	if (isset($searchFormOptions['hide_form']) and !empty($searchFormOptions['hide_form'])) {
		$sForm['hideForm'] = $searchFormOptions['hide_form'];
	}
}

// Country Map status (shown/hidden)
$showMap = false;
if (file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')) {
	if (isset($citiesOptions) and isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
		$showMap = true;
	}
}
$hideOnMobile = '';
if (isset($searchFormOptions, $searchFormOptions['hide_on_mobile']) and $searchFormOptions['hide_on_mobile'] == '1') {
	$hideOnMobile = ' hidden-sm';
}
?>
@if (isset($sForm['enableFormAreaCustomization']) and $sForm['enableFormAreaCustomization'] == '1')
	
	@if (isset($firstSection) and !$firstSection)
		<div class="h-spacer"></div>
	@endif
	
	<?php $parallax = (isset($sForm['parallax']) and $sForm['parallax'] == '1') ? 'parallax' : ''; ?>
	<div class="wide-intro {{ $parallax }}{{ $hideOnMobile }}">
		<div class="dtable hw100">
			<div class="dtable-cell hw100">
				<div class="container text-center">
					
					@if ($sForm['hideTitles'] != '1')
						<h1 class="intro-title animated fadeInDown"> {{ $sForm['title'] }} </h1>
						<p class="sub animateme fittext3 animated fadeIn">
							{!! $sForm['subTitle'] !!}
						</p>
					@endif
					
					@if ($sForm['hideForm'] != '1')
						<div class="search-row animated fadeInUp rounded">
							<!--<form id="search" name="search" action="{{ 'live_search/' }}" method="GET">-->
							{{-- home search fields --}}
							<form id="search" name="search" action="{{  route('live_search.index')  }}" method="GET">
								<div class="row m-0">

								<div class="col-md-5 col-sm-12 mb-1 mb-xl-0 mb-lg-0 mb-md-0 search-col relative">
										<i class="icon-tag icon-append"></i>
									<input type="text" name="title_search" class="form-control keyword has-icon" placeholder="Title..." value="">
									
									
               
									</div>
									<div class="col-md-5 col-sm-12 mb-1 mb-xl-0 mb-lg-0 mb-md-0 search-col relative">
										<i class="icon-docs icon-append"></i>
									<!--	<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('what') }}" value="">-->
									
									<select id="get_industry" name="get_industries[]" class="form-control" multiple></select>
               
									</div>
									
									<div class="col-md-5 col-sm-12 search-col relative locationicon">
										<i class="icon-location-2 icon-append"></i>
										
										<select id="get_countries" name="country_list[]" class="form-control" multiple></select>
               	
									</div>
									
									<div class="col-md-2 col-sm-12 search-col">
										<button class="btn btn-primary btn-search btn-block">
											<i class="icon-search"></i> <strong>{{ t('find') }}</strong>
										</button>
									</div>
								</div>
							</form>
						</div>
					@endif
				
				</div>
			</div>
		</div>
	</div>
	
@else
	
	@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'])
	<div class="container">
		<div class="intro rounded">
			<div class="dtable hw100">
				<div class="dtable-cell hw100">
					<div class="container text-center">
						
						<div class="search-row fadeInUp">
							<form id="search" name="search" action="{{ \App\Helpers\UrlGen::search() }}" method="GET">
								<div class="row m-0">
									<div class="col-md-5 col-sm-12 mb-1 mb-xl-0 mb-lg-0 mb-md-0 search-col relative">
										<i class="icon-docs icon-append"></i>
										<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('what') }}" value="">
									</div>
									
									<div class="col-md-5 col-sm-12 search-col relative locationicon">
										<i class="icon-location-2 icon-append"></i>
										<input type="hidden" id="lSearch" name="l" value="">
										@if ($showMap)
											<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
												   placeholder="{{ t('where') }}" value="" title="" data-placement="bottom"
												   data-toggle="tooltip" type="button"
												   data-original-title="{{ t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name') }}">
										@else
											<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon"
												   placeholder="{{ t('where') }}" value="">
										@endif
									</div>
									
									<div class="col-md-2 col-sm-12 search-col">
										<button class="btn btn-primary btn-search btn-block">
											<i class="icon-search"></i> <strong>{{ t('find') }}</strong>
										</button>
									</div>
									{!! csrf_field() !!}
								</div>
							</form>
						</div>
	
					</div>
				</div>
			</div>
		</div>
	</div>
	
@endif
 <!-- JS, Popper.js, and jQuery -->
 <script  src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
		<!-- CSS only -->
		<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->

		
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#get_industry').select2({
            placeholder: "Choose Industries...",
            minimumInputLength: 2,
            ajax: {
                url: "{{route('live_search.get_industries')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        $('#get_countries').select2({
            placeholder: "Choose Countries...",
            minimumInputLength: 2,
            ajax: {
                url: "{{route('live_search.get_countries')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>