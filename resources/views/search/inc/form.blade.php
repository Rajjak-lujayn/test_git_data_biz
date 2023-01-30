<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->id : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = request()->get('r');
} else {
	$qLocationId = request()->get('l');
	$qLocation = (request()->filled('r')) ? t('area') . rawurldecode(request()->get('r')) : request()->get('location');
    $qAdmin = request()->get('r');
}
?>
<div class="search-form-wrapper">
    <div class="container">
    	<div class="search-row-wrapper rounded">
    		<div class="container">
				{{-- Search fields on list page --}}
    			<!--<form id="seach" name="search" action="{{ \App\Helpers\UrlGen::search() }}" method="GET">-->
    			<form id="seach" name="search" autocomplete="off">  
    				<div class="row m-0">
    					
						<div class="col-xl-4 col-md-4 col-sm-12 col-12">
    						<input name="title_search" id="getSearchTitle" class="form-control keyword" type="text" placeholder="Title..." value="<?php echo $_GET['title_search'];?>">
    					</div>
    					<div class="col-xl-3 col-md-3 col-sm-12 col-12">
    					<select id="get_industry" name="get_industries[]" class="form-control" multiple></select>
                   
    					<!--	<select name="c" id="catSearch" class="form-control selecter" >
    							<option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}>
    								{{ 'All Industries' }}
    							</option>
    							@if (isset($industries) && $industries->count() > 0)
    								@foreach ($industries as $iCat)
    							
    									<option  value="{{ $iCat->Industry }}">
    									{{$iCat->Industry}}
    									</option>
    								@endforeach
    							@endif
    						</select>-->
    					</div>
    					
    					<!--<div class="col-xl-4 col-md-4 col-sm-12 col-12">-->
    					<!--	<input name="q" class="form-control keyword" type="text" placeholder="{{ t('what') }}" value="{{ $keywords }}">-->
    					<!--</div>-->
    					
    					<div class="col-xl-3 col-md-3 col-sm-12 col-12 search-col locationicon">
    						<!--<i class="icon-location-2 icon-append"></i>-->
    						<select id="get_countries" name="country_list[]" class="form-control" multiple></select>
                   	
    					</div>
    	
    					<input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
    					<input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">
    	
    					<div class="col-xl-2 col-md-2 col-sm-12 col-12">
    						<button class="btn btn-block btn-primary" id="searchButton">
    							<i class="fa fa-search"></i> <strong>{{ t('find') }}</strong>
    						</button>
							
    					</div>

						<div class="col-xl-2 col-md-2 col-sm-12 col-12">
    						
							<button class="btn btn-block btn-primary" id="clearSearch">
								<strong>{{ ('Clear Search') }}</strong>
						   </button>
    					</div>
    					
    				</div>
    		    </form>
    		</div>
    	</div>
    </div>
</div>
@section('after_scripts')
	@parent

	<script>
		
		$(document).ready(function () {
			$('#locSearch').on('change', function () {
				if ($(this).val() == '') {
					$('#lSearch').val('');
					$('#rSearch').val('');
				}
			});

			// changes by rajjak jan 24, 2023 for clear industry, countries and title search values
			$('#clearSearch').click(function(){
				$("#get_industry").text('');
				$("#get_countries").text('');
				$("#getSearchTitle").val('');
				
			});
			// end
		});
	</script>
@endsection
