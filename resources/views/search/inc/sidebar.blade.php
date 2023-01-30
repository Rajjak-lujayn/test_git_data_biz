<!-- this (.mobile-filter-sidebar) part will be position fixed in mobile version -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />-->


{{-- sidebar filters columns --}}

<div class="col-md-3 page-sidebar mobile-filter-sidebar pb-4">
    <aside>
        <div class="sidebar-modern-inner enable-long-words">

            <table cellpadding="3" cellspacing="0" border="0" id="liveSearchLeftFilter"
                style="width: 67%; margin: 0 auto 2em auto;">
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
                    {{-- changes by rajjak for hide firstname and lastname in filters--}}

                    {{-- <tr id="filter_col1" data-column="3">
                <td>FirstName</td>
                <td align="center"><input type="text" class="column_filter" id="col3_filter" ></td>
                   </tr>
            <tr id="filter_col2" data-column="4">
                <td>LastName</td>
                <td align="center"><input type="text" class="column_filter" id="col4_filter"></td>
                       </tr> --}}

                    {{-- end --}}
                    <tr id="filter_col3" data-column="5">
                        <td>Title</td>
                        <td align="center">
                            {{-- changes by rajjak multiple select title--}}
                            {{-- <input type="text" class="column_filter" id="col5_filter"> --}}
                            <select multiple="true" class="column_filter" name="Title[]" id="col5_filter"></select>
                            {{-- end --}}
                        </td>
                    </tr>
                    <tr id="filter_col3" data-column="6">
                        <td> Email ID</td>
                        <td align="center"><input type="text" class="column_filter" id="col6_filter"></td>
                    </tr>

                    <tr id="filter_col4" data-column="7">
                        <td> Company Name</td>
                        <td align="center">
                            {{-- changes by rajjak for multiple select company--}}
                            {{-- <input type="text" class="column_filter" id="col7_filter"> --}}
                            <select multiple="true" class="column_filter" name="Company[]" id="col7_filter"></select>
                            {{-- end --}}
                        </td>
                    </tr>
                    {{-- changes by rajjak for hide phone fields  --}}

                    {{-- <tr id="filter_col5" data-column="8">
                <td>Phone1</td>
                <td align="center"><input type="text" class="column_filter" id="col8_filter"></td>
                   </tr> --}}

                    {{-- end --}}

                    <!--<tr id="filter_col6" data-column="9">
                <td>Phone2</td>
                <td align="center"><input type="text" class="column_filter" id="col9_filter"></td>
                    </tr>-->
                    <tr id="filter_col7" data-column="10">
                        <td>WebSite</td>
                        <td align="center">
                            {{-- changes by rajjak jan 17, 2023 for select multiple website --}}
                            {{-- <input type="text" class="column_filter" id="col10_filter"> --}}
                            <select multiple="true" class="column_filter" name="Website[]" id="col10_filter"></select>
                            {{-- end --}}
                        </td>
                    </tr>

                    <tr id="filter_col8" data-column="11">
                        <td>Employee Size</td>

                        <td align="center">
                            {{-- changes by rajjak for employeesize--}}
                            <div class="employesizes_select">
                                <select aria-placeholder="fhg" multiple="true" name="EmployeeSize[]" id="col11_filter"
                                    class="group_field form-control selecter EmployeeSize_selector">
                                    {{-- <option>Please Select</option> --}}
                                    {{-- <option value="myself only">MySelf Only</option> --}}
                                    {{-- <option value="myself only">MySelf Only</option> --}}
                                    {{-- <option value="0-1,0 - 1,0 - 1 employees,0-1 employees">0-1</option>
                                    <option value="2-10,2 - 10,2 - 10 employees,2-10 employees">2-10</option>
                                    <option value="11-50,11 - 50,11 - 50 employees,11-50 employees">11-50 </option>
                                    <option value="51-200,51 - 200,51 - 200 employees,51-200 employees">51-200 </option>
                                    <option value="201-500,201 - 500,201 - 500 employees,201-500 employees">201-500</option>
                                    <option value="501-1000,501 - 1000,501 - 1000 employees,501-1000 employees">501-1000</option>
                                    <option value="1001-5000,1001 - 5000,1001 - 5000 employees,1001-5000 employees">1001-5000 </option>
                                    <option value="5001-10000,5001 - 10000,5001 - 10000 employees,5001-10000 employees">5001-10000 </option>
                                    <option value="10001+ employees,10001+">10,001+ </option> --}}


                                    <option value="0-1">0-1</option>
                                    <option value="2-10">2-10</option>
                                    <option value="11-50">11-50 </option>
                                    <option value="51-200">51-200 </option>
                                    <option value="201-500">201-500</option>
                                    <option value="501-1000">501-1000</option>
                                    <option value="1001-5000">1001-5000 </option>
                                    <option value="5001-10000">5001-10000 </option>
                                    <option value="10001+">10,001+ </option>
                                </select>
                            </div>
                            {{-- end --}}

                            <!--<input type="text" class="column_filter" id="col10_filter">-->
                        </td>
                       
                    </tr>

                    <tr id="filter_col9" data-column="12">
                        <td>Revenue</td>
                        <td align="center">
                            {{-- changes by rajjak for multiple select --}}
                            {{-- <select multiple="true" name="revenue[]" id="col12_filter" class="group_field form-control selecter"> --}}

                                <select name="revenue[]"  multiple="true" id="col12_filter" class="group_field form-control selecter">
                                    @if (isset($revenue) && $revenue->count() > 0)
                                        {{-- <option value="">  </option> --}}
                                        {{-- changes by rajjak jan 19, 2023 --}}
                                        <?php $logic = "1000M" ?>
                                        {{-- end --}}
                                        @foreach ($revenue as $rev)
                                            <?php $split = explode('-', $rev->revenue);
    
                                            //changes by rajjak jan 19, 2023  for convert revenue in alpha numeric values
                                            if(isset($split[1])){
                                                //end
                                            $splitRevenue = '$' . $split[0] . '-$' . $split[1]; ?>
                                            <?php $input = $rev->revenue; ?>
                                            <?php $aray = []; ?>
                                            @foreach (explode('-', $input) as $key => $info)
                                                <?php $test = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $info); ?>
                                                <?php $a = $test[1]; ?>
    
                                                <?php $no_k = str_replace($a, '', $test[0]); ?>
    
                                                <?php $dotted = str_replace(',', '.', $no_k); ?>
    
                                                <?php/* $aray[$key] = $dotted * 1000; */?>
                                                @if ($a == 'M')
                                                    <?php $aray[$key] = $dotted * 1000000; ?>
                                                    
                                                    <?php/* $aray[$key] = $dotted * 1000000000; */?>
                                                @endif
                                            @endforeach
    
                                            <option value="{{ implode('-', $aray) }}">
                                                
                                                {{ $splitRevenue }}
                                                
                                            </option>
                                            {{-- changes by rajjak jan 19, 2023 --}}
                                           <?php } else { ?>
                                            <?php $test = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $logic); ?>
                                            <?php $a = $test[1]; ?>
    
                                            <?php $no_k = str_replace($a, '', $test[0]); ?>
    
                                            <?php $dotted = str_replace(',', '.', $no_k); ?>
    
                                            <?php/* $aray[$key] = $dotted * 1000; */?>
                                            @if ($a == 'M')
                                                <?php $values = $dotted * 1000000; ?>
                                                
                                                <?php/* $aray[$key] = $dotted * 1000000000; */?>
                                               <?php echo $values;?>
                                                <option value="{{1000000001}}">
                                                    {{ "$1000M+" }}
                                                </option>
                                            @endif
                                        <?php   } ?>
                                        {{-- end --}}
                                        @endforeach
    
                                       
    
                                    @endif
                                </select>
                            <!-- <input type="text" class="column_filter" id="col11_filter">-->
                        </td>
                    </tr>
                    <!--<tr id="filter_col10" data-column="13">
                <td>LinkedInPersonal</td>
                <td align="center"><input type="text" class="column_filter" id="col13_filter"></td>
                 </tr>
            <tr id="filter_col11" data-column="14">
                <td>LinkedInCompany</td>
                <td align="center"><input type="text" class="column_filter" id="col14_filter"></td>
                </tr>-->
                    <tr id="filter_col12" data-column="15">
                        <td>City</td>
                        <td align="center"><input type="text" class="column_filter" id="col15_filter"></td>
                    </tr>
                    <tr id="filter_col6" data-column="16">
                        <td>State</td>
                        <td align="center"><input type="text" class="column_filter" id="col16_filter"></td>
                    </tr>
                    <tr id="filter_col6" data-column="17">
                        <td>Zip</td>
                        <td align="center"><input type="text" class="column_filter" id="col17_filter"></td>
                    </tr>
                    <tr id="filter_col6" data-column="18">
                        <td>Country</td>
                        <td align="center"><input type="text" class="column_filter" id="col18_filter"></td>

                    </tr>
                    <tr id="filter_col6" data-column="19">
                        <td>Industry</td>
                        <td align="center">
                            <input type="text" class="column_filter" id="col19_filter">

                        </td>
                        {{-- changes by rajjak for hide subindustry--}}

                        {{-- <tr id="filter_col6" data-column="20">
                <td>SubIndustry</td>
                <td align="center"><input type="text" class="column_filter" id="col20_filter"></td>
                 </tr> --}}

                        {{-- end --}}

                        {{-- changes by rajjak jan 17, 2023 for add CompanyHeadquarter columns --}}
                        <tr id="filter_col6" data-column="23">
                            <td>CompanyHeadquarter</td>
                            <td align="center"><input type="text" class="column_filter" id="col23_filter"></td>
    
                        </tr>
                        {{-- end --}}

                        {{-- changes by rajjak for add clear values button--}}

                    <tr>
                        <td>
                            <button type="button" id="clear" class="btn btn-primary">Clear Filters</button>
                        </td>
                    </tr>

                    {{-- end --}}
                </tbody>
            </table>
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
            dropdownAutoWidth: 'true',
            minimumResultsForSearch: Infinity,
            width: '100%',
            ajax: {
                url: "{{ route('live_search.get_industries') }}",
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
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
            dropdownAutoWidth: 'true',
            minimumResultsForSearch: Infinity,
            width: '100%',
            ajax: {
                url: "{{ route('live_search.get_countries') }}",
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            formatSelection: function(element) {
                console.log(element);
                return element.text + ' (' + element.id + ')';
            }
        });

        // changes by rajjak jan 12 and 13 for multiple title
        $('#col5_filter').select2({
            placeholder: "",
            minimumInputLength: 3,
            dropdownAutoWidth: 'true',
            minimumResultsForSearch: Infinity,
            width: '100%',
            ajax: {
                url: "{{ route('live_search.get_title') }}",
                dataType: 'json',
                data: function(params) {

                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    // console.log(data);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        //for multiple company
        $('#col7_filter').select2({
            placeholder: "",
            minimumInputLength: 3,
            dropdownAutoWidth: 'true',
            minimumResultsForSearch: Infinity,
            width: '100%',
            ajax: {
                url: "{{ route('live_search.get_company') }}",
                dataType: 'json',
                data: function(params) {

                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    // console.log(data);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        //for multiple website
        $('#col10_filter').select2({
            placeholder: "",
            minimumInputLength: 3,
            dropdownAutoWidth: 'true',
            minimumResultsForSearch: Infinity,
            width: '100%',
            ajax: {
                url: "{{ route('live_search.get_website') }}",
                dataType: 'json',
                data: function(params) {

                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    // console.log(data);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        // end
        //         var $newOption = $("<option selected='selected'></option>").val("United States").text("United States")

        // $("#get_countries").append($newOption).trigger('change');
    </script>
    <script>
        var baseUrl = '{{ request()->url() }}';
    </script>

    <script src="{{ url('assets/js/saveSearch.js') . getPictureVersion() }}"></script>
@endsection