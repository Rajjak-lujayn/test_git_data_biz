<!-- this (.mobile-filter-sidebar) part will be position fixed in mobile version -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />


                      
<div class="col-md-3 page-sidebar mobile-filter-sidebar pb-4">
	<aside>
		<div class="sidebar-modern-inner enable-long-words">
<form id="search_sidebar" name="search_sidebar" autocomplete="off">  
		<table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
        <thead>
            <tr>
                <th>Filters</th>
                <th></th>
             
            </tr>
        </thead>
        <tbody>
            <!--<tr id="filter_global">-->
            <!--    <td>Global search</td>-->
            <!--    <td align="center"><input type="text" class="global_filter" id="global_filter"></td>-->
            <!--    </tr>-->
            <tr id="filter_col1" data-column="2">
                <td>FirstName</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col2_filter" ></td>
                   </tr>
            <tr id="filter_col2" data-column="3">
                <td>LastName</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col3_filter"></td>
                       </tr>
            <tr id="filter_col3" data-column="4">
                <td>Title</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col4_filter"></td>
                 </tr>
            <tr id="filter_col3" data-column="5">
                <td> Email ID</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col5_filter"></td>
                
            </tr>

            <tr id="filter_col4" data-column="6">
                <td> Company Name</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col6_filter"></td>
                           </tr>
           <tr id="filter_col5" data-column="7">
                <td>Phone1</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col7_filter"></td>
                   </tr>
            <tr id="filter_col6" data-column="8">
                <td>Phone2</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col8_filter"></td>
                    </tr>
            <tr id="filter_col7" data-column="9">
                <td>WebSite</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col9_filter"></td>
                     </tr>
            <tr id="filter_col8" data-column="10">
                <td>EmplyoeeSize</td>
                <td align="center">
                   <!-- <input type="text" autocomplete="off" class="column_filter" id="col10_filter"> -->
                <select id="get_employeesize" name="get_employeesize[]" class="form-control" multiple></select>
                    </td>
                      </tr>
            <tr id="filter_col9" data-column="11">
                <td>Revenue</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col11_filter"></td>
                 </tr>
            <tr id="filter_col10" data-column="12">
                <td>LinkedInPersonal</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col12_filter"></td>
                 </tr>
            <tr id="filter_col11" data-column="13">
                <td>LinkedInCompany</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col13_filter"></td>
                </tr>
            <tr id="filter_col12" data-column="14">
                <td>City</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col14_filter"></td>
                </tr>
            <tr id="filter_col6" data-column="15">
                <td>State</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col15_filter"></td>
                </tr>
            <tr id="filter_col6" data-column="16">
                <td>Zip</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col16_filter"></td>
                 </tr>
            <tr id="filter_col6" data-column="17">
                <td>Country</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col17_filter"></td>
              
            </tr>
            <tr id="filter_col6" data-column="18">
                <td>Industry</td>
                <td align="center">
                <input type="text" autocomplete="off" class="column_filter" id="col18_filter">
                
            </td>
                         </tr>
            <tr id="filter_col6" data-column="19">
                <td>SubIndustry</td>
                <td align="center"><input type="text" autocomplete="off" class="column_filter" id="col19_filter"></td>
                 </tr>
        </tbody>
    </table>
    </form>
		    {{-- @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.industries', 'search.inc.sidebar.industries'])
			@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.fields', 'search.inc.sidebar.fields'])
			@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories', 'search.inc.sidebar.categories'])
            @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.cities', 'search.inc.sidebar.cities'])
			@if (!config('settings.listing.hide_dates'))
				@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.date', 'search.inc.sidebar.date'])
			@endif
			@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.price', 'search.inc.sidebar.price']) --}}
			
		</div>
	</aside>
</div>

@section('after_scripts')
    @parent
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
        
         $('#get_employeesize').select2({
            placeholder: "Employee Size...",
            minimumInputLength: 2,
            ajax: {
                url: "{{route('live_search.get_employeesize')}}",
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
            },
      formatSelection: function(element){
          console.log(element);
          return element.text + ' (' + element.id + ')';
      }
        });
//         var $newOption = $("<option selected='selected'></option>").val("United States").text("United States")
 
// $("#get_countries").append($newOption).trigger('change');
    
    </script>
    <script>
        var baseUrl = '{{ request()->url() }}';
    </script>
@endsection