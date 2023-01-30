{{--
 --}}
 @extends('layouts.master')

 <?php
     $addListingUrl = (isset($addListingUrl)) ? $addListingUrl : \App\Helpers\UrlGen::addPost();
     $addListingAttr = '';
     if (!auth()->check()) {
         if (config('settings.single.guests_can_post_ads') != '1') {
             $addListingUrl = '#quickLogin';
             $addListingAttr = ' data-toggle="modal"';
         }
     }
 ?>
 @section('content')
     @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
     <div class="main-container">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3 page-sidebar">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div>
				<!--/.page-sidebar-->
				
				<div class="col-md-9 page-content">
					<div class="inner-box">

            <center>
            <h3>Your Available Credit Balance :<b> {{ auth()->user()->credit_limit }}</b></h3>
                </center>
                    <hr class="center-block  mt-0">
                        
                        <h1 class="text-center title-1" style="text-transform: none;">
                            <strong>Buy New Credits</strong>
                        </h1>
             
             
             <p class="text-center">
                 
             </p>
             
             <div class="row mt-5 mb-md-5 justify-content-center">
                 @if ($packages->count() > 0)
                     @foreach($packages as $package)
                         <?php
                             $boxClass = ($package->recommended == 1) ? ' border-color-primary' : '';
                             $boxHeaderClass = ($package->recommended == 1) ? ' bg-primary border-color-primary text-white' : '';
                             $boxBtnClass = ($package->recommended == 1) ? ' btn-primary' : ' btn-outline-primary';
                         ?>
                         <div class="col-md-4">
                             <div class="card mb-4 box-shadow{{ $boxClass }}">
                                 <div class="card-header text-center{{ $boxHeaderClass }}">
                                     <h4 class="my-0 font-weight-normal pb-0 h4">
                                     <?php   print_r($package->pictures_limit); ?> Credits for
                                     {{-- $package->name --}}</h4>
                                 </div>
                                 <div class="card-body">
                                     <h1 class="text-center">
                                         <span class="font-weight-bold">
                                             @if ($package->currency->in_left == 1)
                                                 {!! $package->currency->symbol !!}
                                             @endif
                                             {{ \App\Helpers\Number::format($package->price) }}
                                             @if ($package->currency->in_left == 0)
                                                 {!! $package->currency->symbol !!}
                                             @endif
                                         </span>
                                       <!--  <small class="text-muted">/ {{ t('package_entity') }}</small>-->
                                     </h1>
                                     <ul class="list list-border text-center mt-3 mb-4">
                                   <li> From this You Will Get   <?php   print_r($package->pictures_limit); ?> Credits </li>
                                        {{-- @if (is_array($package->description_array) and count($package->description_array) > 0)
                                             @foreach($package->description_array as $option)
                                                 <li>{!! $option !!}</li>
                                             @endforeach
                                         @else
                                             <li> *** </li>
                                         @endif --}}
                                     </ul>
                                     <?php
                                     $pricingUrl = '';
                                     if (\Illuminate\Support\Str::startsWith($addListingUrl, '#')) {
                                         $pricingUrl = '' . $addListingUrl;
                                     } else {
                                         $pricingUrl = $addListingUrl . '?package=' . $package->id;
                                     }
                                     ?>
                                     <a href="checkout/plan/{{$package->id}}"
                                        class="btn btn-lg btn-block{{ $boxBtnClass }}"{!! $addListingAttr !!}
                                     >
                                        Buy Now
                                     </a>
                                 </div>
                             </div>
                         </div>
                     @endforeach
                 @else
                     <div class="col-md-6 col-sm-12 text-center">
                         <div class="card bg-light">
                             <div class="card-body">
                                 {{ t('no_package_available') }}
                             </div>
                         </div>
                     </div>
                 @endif
             </div>
             


         </div>
     </div>
     </div>
 @endsection
 
 @section('after_styles')
 @endsection
 
 @section('after_scripts')
 @endsection