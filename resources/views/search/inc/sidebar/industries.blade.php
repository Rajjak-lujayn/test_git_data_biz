<!-- Category -->
<div id="catsList">
	<div class="block-title has-arrow sidebar-header">
		<h5>
			<span class="font-weight-bold">
				{{ 'All Industries' }} 
			</span> {!! $clearFilterBtn ?? '' !!}
		</h5>
	</div>
	<div class="block-content list-filter categories-list">
		<ul class="list-unstyled">
			@if (isset($industries) && $industries->count() > 0)
				@foreach ($industries as $iCat)
					<li>
						{{$iCat->Industry}}
					</li>
				@endforeach
			@endif
		</ul>
	</div>
</div>
<div style="clear:both"></div>