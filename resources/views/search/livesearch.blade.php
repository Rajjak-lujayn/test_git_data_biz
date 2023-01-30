{{--
 --}}
 @extends('layouts.master')

 @section('search')
     @parent
     @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.form', 'search.inc.form'])
 @endsection
 {{-- @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.form', 'search.inc.form']) --}}
 @section('content')
     <div class="main-container" id="search_result-main">
 
 
         <!--@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])-->
         <div class="search-form-results">
             <div class="container">
                 <div class="row">
 
                     <!-- Sidebar -->
                     @includeFirst([
                         config('larapen.core.customizedViewPath') . 'search.inc.sidebar',
                         'search.inc.sidebar',
                     ])
                     <?php $contentColSm = 'col-md-9'; ?>
                     @if (config('settings.listing.left_sidebar'))
                         {{-- @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar', 'search.inc.sidebar']) --}}
                         <?php $contentColSm = 'col-md-9'; ?>
                     @else
                         <?php $contentColSm = 'col-md-12'; ?>
                     @endif
 
                     <!-- Content -->
                     <div class="{{ $contentColSm }} page-content col-thin-left">
                         <div class="container">
                             <div class="card">
                                 <a data-href="/live_search/exportCsv" class="btn btn-filter btn-secondary"
                                     id="export_records">Export
                                     Selected</a>
                                 <button id="saveSearch" class="save-this-search" style="display: none">Save This
                                     Search</button>
                                 <div class="card-body">
                                     <div class="table-responsive">
                                         <div class="search_main-table">
                                                {{-- changes by rajjak for show filter values --}}                                             <div id="apnd">
                                                 <span class="filter_table_content" data-title="Title"></span>
                                                 <span class="filter_table_content" data-title="EmailID"></span>
                                                 <span class="filter_table_content" data-title="CompanyName"></span>
                                                 <span class="filter_table_content" data-title="WebSite"></span>
                                                 <span class="filter_table_content" data-title="EmployeeSize"></span>
                                                 <span class="filter_table_content" data-title="Revenue"></span>
                                                 <span class="filter_table_content" data-title="City"></span>
                                                 <span class="filter_table_content" data-title="State"></span>
                                                 <span class="filter_table_content" data-title="Zip"></span>
                                                 <span class="filter_table_content" data-title="Country"></span>
                                                 <span class="filter_table_content" data-title="Industry"></span>
                                                 <span class="filter_table_content" data-title="CompanyHeadquarter"></span>
                                             </div>
                                             {{-- end --}}
                                             <table id="sample_data" class="table table-bordered table-striped">
                                                 <thead>
                                                     <tr>
                                                         <th><input type="checkbox" name="select_all" value="1"
                                                                 id="example-select-all"></th>
 
                                                         <th></th>
                                                         <th>Data Id</th>
                                                         <th>First Name</th>
                                                         <th>Last Name</th>
                                                         <th>Title</th>
                                                         <th>Email</th>
                                                         <th>Company Name</th>
                                                         <th>Phone1</th>
                                                         <th>Phone2</th>
                                                         <th>Website</th>
                                                         <th>EmplyoeeSize</th>
                                                         <th>Revenue</th>
                                                         <th>LinkedInPersonal</th>
                                                         <th>LinkedInCompany </th>
                                                         <th>City</th>
                                                         <th>State</th>
                                                         <th>Zip</th>
                                                         <th>Country</th>
                                                         <th>Industry</th>
                                                         <th>SubIndustry</th>
                                                         <th>SIC</th>
                                                         <th>NAICS</th>
 
                                                     </tr>
                                                 </thead>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
 
 
 
                         <div style="clear:both;"></div>
 
                         <!-- Advertising -->
                         @includeFirst([
                             config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom',
                             'layouts.inc.advertising.bottom',
                         ])
 
                     </div>
                 </div>
             </div>
         </div>
     @endsection
 
 
 
     @section('modal_location')
         @includeFirst([
             config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location',
             'layouts.inc.modal.location',
         ])
     @endsection
 
     @section('after_scripts')
         <!-- JS, Popper.js, and jQuery -->
         <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
             crossorigin="anonymous"></script>
         <!-- CSS only -->
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
             integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
             integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
         </script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
             integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
         </script>
         <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
         <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
         <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
         <link rel="stylesheet"
             href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
         <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
         <link rel="stylesheet" type="text/css"
             href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
         <script type="text/javascript"
             src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js">
         </script>
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 
         <style>
             td.details-control {
                 background: url('details_open.png') no-repeat center center;
                 cursor: pointer;
             }
 
             tr.shown td.details-control {
                 background: url('details_close.png') no-repeat center center;
             }
         </style>
 
         <script type="text/javascript" language="javascript">
             // 
 
             $(document).ready(function() {
                 $(".dropdown-link-menu").click(function() {
                     console.log("ready!");
                     $("#userMenuDropdown").toggle();
 
                 });
             });
 
 
             function filterGlobal() {
                 $('#sample_data').DataTable().search(
                     $('#global_filter').val(),
                     $('#global_regex').prop('checked'),
                     $('#global_smart').prop('checked')
                 ).draw();
             }
 
             function callDatatable() {
                 var industry = $("#get_industry").val();
                 var country = $("#get_countries").val();
 
                 if ((country == '' || country == 'undefined' || country == null) && (industry == '' || industry ==
                         'undefined' || industry == null)) {
 
                     $('#sample_data').DataTable().draw();
                 }
 
 
                 if (industry == '' || industry == 'undefined' || industry == null) {
 
 
                 } else {
 
                     $('#sample_data').DataTable().column(18).search(industry).draw();
                 }
 
                 if (country == '' || country == 'undefined' || country == null) {
                     // alert("Null");
 
                 } else {
                     $('#sample_data').DataTable().column(17).search(country).draw();
                 }
 
 
 
             }
 
             function filterColumn(i) {
                 // changes by urmi/rajjak jan 24, 2023
                 if(i == 7){
                     var data = [];
                     $( "#filter_col4 ul li" ).each(function( index ) {
                             var val =  $( this ).text().toString();
                             data.push(val.replace(',', '@'));
                      });
                      company = data.join(',');
                 }else{
                     company = $('#col' + i + '_filter').val();
                 }
                 // end
                 $('#sample_data').DataTable().column(i).search(
                    /* $('#col' + i + '_filter').val(), */
                    // changes by urmi/rajjak jan 24, 2023
                    company,
                     //    end
                     $('#col' + i + '_regex').prop('checked'),
                     $('#col' + i + '_smart').prop('checked')
                 ).draw();
             }
 
             function format(d) {
                 // `d` is the original data object for the row
                 //changes by rajjak
                 //for filter revenue value in alphanumeric form
                 var revenueData = d.Revenue.split("-");
                 var aray = [];
                 for (var i = 0, l = revenueData.length; i < l; i++) {
                     if (revenueData[i] >= 1000000000) {
                         aray[i] = (revenueData[i] / 1000000000).toFixed(1).replace(/\.0/, '') + 'B';
                     } else if (revenueData[i] >= 1000000) {
                         aray[i] = (revenueData[i] / 1000000).toFixed(1).replace(/\.0/, '') + 'M';
                     } else if (revenueData[i] >= 1000) {
                         aray[i] = (revenueData[i] / 1000).toFixed(1).replace(/\.0/, '') + 'K';
                     } else if (revenueData[i] < 1000) {
                         aray[i] = (revenueData[i]);
                     }
                 }
                 var arr_revenue = aray.join("-");
 
                 // changes by rajjak jan 11, 2023 for hide & when phone is not available
                 if (d.Phone1 != "" && d.Phone2 != "") {
                     var and = " & ";
                 } else {
                     var and = "";
                 }
                 // end
 
                 //end 
                 return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                     '<tr>' +
                     '<td>Full name:</td>' +
                     '<td>' + d.FirstName + ' ' + d.LastName + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>Title:</td>' +
                     '<td>' + d.Title + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>Phone1 & Phone2:</td>' +
                     '<td>' + d.Phone1 + and + d.Phone2 + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>Email ID:</td>' +
                     '<td>' + d.OEmail + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>Website:</td>' +
                     '<td>' + d.Website + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>EmplyoeeSize:</td>' +
                     '<td>' + d.EmplyoeeSize + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>Revenue In (USD):</td>' +
                     '<td>' + arr_revenue + '</td>' + //changes by rajjak
                     '</tr>' +
                     '<tr>' +
                     '<td>LinkedInCompany:</td>' +
                     '<td>' + d.LinkedInCompany + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>Industry:</td>' +
                     '<td>' + d.Industry + '</td>' +
                     '</tr>' +
                     '<tr>' +
                     '<td>Country:</td>' +
                     '<td>' + d.Country + '</td>' +
                     '</tr>' +
                     // changes by rajjak jan 17, 2023 for add/show CompanyHeadquarter in listing result
                     '<tr>' +
                     '<td>CompanyHeadquarter:</td>' +
                     '<td>' + d.CompanyHeadquarter + '</td>' +
                     '</tr>' +
                     //end
 
                     '</table>';
             }
 
             $(document).ready(function() {
 
                 var dataTable = $('#sample_data').DataTable({
                     "processing": true,
                     "serverSide": true,
 
                     dom: '<"top"il<"clear">>rt<"bottom"ip<"clear">>',
                     buttons: [],
                     "order": [],
                     "columns": [{
                             "className": 'dt-body-center',
                             "orderable": false,
                             "searchable": false,
                             "data": "id",
                             // "defaultContent": ''
                             'render': function(data, type, full, meta) {
                                 return '<input type="checkbox" name="id[]" class="data_ids" value="' +
                                     $('<div/>').text(data).html() + '">';
                             }
                         },
                         {
                             "className": 'details-control',
                             "orderable": false,
                             "searchable": false,
                             "data": null,
                             "defaultContent": ''
                         },
                         {
                             "data": "id",
                             "visible": false,
                             "searchable": false
                         },
                         {
                             "data": "FirstName"
                         },
                         {
                             "data": "LastName"
                         },
                         {
                             "data": "Title"
                         },
                         {
                             "data": "Email"
                         },
                         {
                             "data": "CompanyName"
                         },
                         {
                             "data": "Phone1",
                             "visible": false
                         },
                         {
                             "data": "Phone2",
                             "visible": false,
                             "searchable": false
                         },
                         {
                             "data": "Website",
                             "visible": false
                         },
                         {
                             "data": "EmplyoeeSize",
                             "visible": false
                         },
                         {
                             "data": "Revenue",
                             "visible": false
                         },
                         {
                             "data": "LinkedInPersonal",
                             "visible": false,
                             "searchable": false
                         },
                         {
                             "data": "LinkedInCompany",
                             "visible": false,
                             "searchable": false
                         },
                         {
                             "data": "City",
                             "visible": false
                         },
                         {
                             "data": "State",
                             "visible": false
                         },
                         {
                             "data": "Zip",
                             "visible": false
                         },
                         {
                             "data": "Country",
                             "visible": false
                         },
                         {
                             "data": "Industry",
                             "visible": false
                         },
                         {
                             "data": "SubIndustry",
                             "visible": false
                         },
                         {
                             "data": "SIC",
                             "visible": false
                         },
                         {
                             "data": "NAICS",
                             "visible": false
                         },
                         // changes by rajjak jan 17, 2023 for show filed
                         {
                             "data": "CompanyHeadquarter",
                             "visible": false
                         }
                         // end
 
 
                     ],
                     "ajax": {
                         url: "{{ route('live_search.action') }}"
                         //type:"POST"
                     },
 
                     createdRow: function(row, data, dataIndex) {
                         // console.log(data);
 
                         $(row).find('td:eq(1)').attr('data-id', data.id);
                     },
                     'iDisplayLength': 50
 
                 });
                 // onload 
 
 
 
                 $(document).ready(function() {
 
                     //   {changes by rajjak}
                     // $test = $('#col11_filter').select2(); // for filter multiple select employeesize
 
 
                     $("#col11_filter").select2();
 
                     // {end}
                     $.ajaxSetup({
                         headers: {
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         }
                     });
 
                     $('#export_records').on('click', function(e) {
 
                         var data_ids = [];
                         $(".data_ids:checked").each(function() {
                             data_ids.push($(this).val());
                         });
                         if (data_ids.length <= 0) {
                             alert("Please select records.");
                         } else {
                             var selected_values = data_ids;
                             
                             $(this).text("Loading...")
                             $(this).attr("disabled", "true")
                             $.ajax({
                                 type: "get",
                                 url: "{{ route('live_search.exportCsv') }}",
                                 cache: false,
                                 data: 'data_ids=' + selected_values,
                                 success: function(response) {
 
                                     if (response == "0") {
                                         set_exists(false);
                                         var title = "Limited Credit";
                                         $('#errorModalTitle').html(title);
                                         var content =
                                             '<h4 class="m-b-20 font-weight-bold">Buy New Credit </h4>';
                                         content +=
                                             '<code><a href="/plans">Click Here</a></code>';
                                         content += '<br><br>';
 
                                         $('#errorModalBody').html(content);
 
 
                                         $('#errorModal').modal('show');
                                         return false;
 
                                     } else {
                                         set_exists(true);
                                         let _url = $("#export_records").data('href');
                                         var selected_values = data_ids;
                                         window.location.href = _url + '?data_ids=' +
                                             selected_values;
                                         // setTimeout(function() {
                                         //     // alert('Reloading Page');
                                         //     location.reload(true);
                                         // }, 2000);
 
                                     }
                                     
                                     $('#export_records').text("Export Selected")
                                     $('#export_records').removeAttr("disabled")
                                     // $('#example-select-all').click();
                                 }
                             });
                         }
 
                     });
 
                 });
 
                 $('#example-select-all').on('click', function() {
                     // Get all rows with search applied
                     var rows = dataTable.rows({
                         'search': 'applied'
                     }).nodes();
                     // Check/uncheck checkboxes for all rows in the table
                     $('input[type="checkbox"]', rows).prop('checked', this.checked);
                 });
 
                 <?php if(isset($_GET["title_search"])):	?>
                 dataTable.column(5).search("<?php echo $_GET['title_search']; ?>").draw();
 
                 <?php  endif; if(isset($_GET["country_list"])):	?>
                 dataTable.column(18).search("<?php echo implode(',', $_GET['country_list']); ?>").draw();
                 <?php endif; if(isset($_GET["get_industries"])): ?>
                 dataTable.column(19).search("<?php echo implode(',', $_GET['get_industries']); ?>").draw();
                 <?php endif; if(isset($_GET["country_list"])):
       // print_r($_GET["country_list"]);
       foreach($_GET["country_list"] as $country):
       ?>
 
                 var $newOption = $("<option selected='selected'></option>").val("<?php echo $country; ?>").text(
                     "<?php echo $country; ?>")
 
                 $("#get_countries").append($newOption).trigger('change');
 
                 <?php endforeach; endif; ?>
                 <?php if(isset($_GET["get_industries"])):
       // print_r($_GET["country_list"]);
       foreach($_GET["get_industries"] as $ind):
       ?>
 
                 var $newOption = $("<option selected='selected'></option>").val("<?php echo $ind; ?>").text(
                     "<?php echo $ind; ?>")
 
                 $("#get_industry").append($newOption).trigger('change');
                 <?php endforeach; endif; ?>
 
                 $('#searchButton').click(function() {
 
                     dataTable.column(19).search($("#get_industry").val()).column(18).search($("#get_countries")
                         .val()).draw();
 
                     // dataTable.search($("#get_industry").val()).draw();
                 });
 
                 $('#get_industry').change(function() {
                     dataTable.column(19).search($("#get_industry").val()).column(18).search($("#get_countries")
                         .val()).draw();
                 });
 
                 $('#get_countries').change(function() {
 
                     dataTable.column(19).search($("#get_industry").val()).column(18).search($("#get_countries")
                         .val()).draw();
 
 
                 });
 
 
                 // changes by rajjak for employee
                 // jan 12, 13 and 16, 2023
                 $('#col11_filter').change(function() {
                     filterColumn($(this).parents('tr').attr('data-column'));
                     // changes by rajjak for clear search value jan 18, 2023
                     var label = $(this).parents('td').prev('td').text();
                     // alert(label);
                     var value = $(this).val();
                     var data_title = label.replace(/\s/gm, '');
                     $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' + value);
 
                     result = $(".filter_table_content[data-title='" + data_title + "']").text().split(':');
 
                     if (result[1] == ' ' || result[1] == " null") {
                         $(".filter_table_content[data-title='" + data_title + "']").text('');
                     }
                     // end
 
                 });
 
                 //  changes by rajjak jan 17, 2023 form website 
                 $('#col10_filter').change(function() {
                     filterColumn($(this).parents('tr').attr('data-column'));
 
                     // changes by rajjak for clear search value jan 18, 2023
                     var label = $(this).parents('td').prev('td').text();
                     var value = $(this).val();
                     var data_title = label.replace(/\s/gm, '');
 
                     $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' + value);
 
                     result = $(".filter_table_content[data-title='" + data_title + "']").text().split(':');
 
                     if (result[1] == ' ' || result[1] == " null") {
                         $(".filter_table_content[data-title='" + data_title + "']").text('');
                     }
                     // end
 
                 });
                 //end
 
                 $("#col12_filter").select2(); //for multiple select revenue 
                 $('#col12_filter').change(function() {
                     filterColumn($(this).parents('tr').attr('data-column'));
                     // changes by rajjak jan 23, 2023 for revanue search view in alphanumeric form
                     var label = $(this).parents('td').prev('td').text();
                     var value = $(this).val();
 
                     var data_title = label.replace(/\s/gm, '');
 
                     var get_char_split = '$';
                     var revenueFilterValue = value.toString().split("-");
 
                     var revenueFilterValueSplit = revenueFilterValue.toString().split(",");
                     var aray = [];
                     for (var i = 0, l = revenueFilterValueSplit.length; i < l; i++) {
                         if (revenueFilterValueSplit[i]) {
                             aray[i] = (revenueFilterValueSplit[i] / 1000000).toFixed(1).replace(/\.0/, '') +
                                 'M';
                         }
                     }
                     var arr_revenue_filter = get_char_split + aray.join("-" + get_char_split);
                     $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' +
                         arr_revenue_filter);
 
                     result = $(".filter_table_content[data-title='" + data_title + "']").text().split(':');
 
                     // end
                 });   
                 // end
 
                 // changes by rajjak for multiple revenue and employee
                 /*$('select.group_field').change(function() {
                              filterColumn($(this).parents('tr').attr('data-column'));
          
                              // {changes by rajjak}
                              var search = $(this).val();
                              var label = $(this).parents('td').prev('td').text();
                              var value = $(this).val();
                              var test = $('#col12_filter').val();
          
                              var data_title = label.replace(/\s/gm, '');
          
                              if (test != '' && data_title != 'EmplyoeeSize') {
                                  var revenueFilterValue = test.split("-");
                                  var aray = [];
                                  // changes dec 21
                                  var get_char_split = '$';
                                  // end
                                  // filter search with alphanumeric form
                                  for (var i = 0, l = revenueFilterValue.length; i < l; i++) {
                                      // changes in dec 21
                                      if (revenueFilterValue[i]) {
                                          aray[i] = (revenueFilterValue[i] / 1000000).toFixed(1).replace(/\.0/, '') + 'M';
                                      }
          
                                      // if (revenueFilterValue[i] >= 1000000000) {
                                      //     aray[i] = (revenueFilterValue[i] / 1000000000).toFixed(1).replace(/\.0$/, '') +
                                      //         'B';
                                      // } 
                                      // else if (revenueFilterValue[i] >= 1000000) {
                                      //     aray[i] = (revenueFilterValue[i] / 1000000).toFixed(1).replace(/\.0$/, '') +
                                      //         'M';
                                      // }
                                      //  else if (revenueFilterValue[i] >= 1000) {
                                      //     aray[i] = (revenueFilterValue[i] / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
          
                                      // }
                                      // end
                                  }
                                  // changes dec 21
          
                                  // var arr_revenue_filter = aray.join("-");
                                  var arr_revenue_filter = get_char_split + aray.join("-" + get_char_split);
                                  //end
          
                                  //display for filter search value
                                  $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' +
                                      arr_revenue_filter);
                              } else {
                                  console.log("test2522");
                                  $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' + value);
          
                              }
          
                              result = $(".filter_table_content[data-title='" + data_title + "']").text().split(':');
                              console.log(result[1]);
          
                              if (result[1] == ' ' || result[1] == " null") {
                                  $(".filter_table_content[data-title='" + data_title + "']").text('');
                              }
          
                              // if (value == null || value == '') {
                              //     $("#apnd").html('');
                              // }
                              // {end}
                          });*/
 
                 // end
 
 
                 $('input.global_filter').on('keyup', function() {
                     filterGlobal();
                 });
 
                 // changes by rajjak 12 and 13 for title multiple select 
                 $("#col5_filter").trigger('change.select2');
                 $('#col5_filter').change(function() {
                     filterColumn($(this).parents('tr').attr('data-column'));
 
                     // changes by rajjak for clear search value jan 18, 2023
                     var label = $(this).parents('td').prev('td').text();
                     var value = $(this).val();
                     var data_title = label.replace(/\s/gm, '');
 
                     $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' + value);
 
                     result = $(".filter_table_content[data-title='" + data_title + "']").text().split(':');
 
                     if (result[1] == ' ' || result[1] == " null") {
                         $(".filter_table_content[data-title='" + data_title + "']").text('');
                     }
                     // end
                 });
 
                 $("#col7_filter").trigger('change.select2'); //changes by rajjak for multiple select company
                 $('#col7_filter').change(function() {
                     filterColumn($(this).parents('tr').attr('data-column'));
 
                     // changes by rajjak for clear search value jan 18, 2023
                     var label = $(this).parents('td').prev('td').text();
                     var value = $(this).val();
                     var data_title = label.replace(/\s/gm, '');
 
                     $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' + value);
 
                     result = $(".filter_table_content[data-title='" + data_title + "']").text().split(':');
 
                     if (result[1] == ' ' || result[1] == " null") {
                         $(".filter_table_content[data-title='" + data_title + "']").text('');
                     }
                     // end
                 });
                 // end
 
 
                 $('input.column_filter').on('keyup', function() {
                     var search = $(this).val();
                     if (search.length >= 3) {
                         filterColumn($(this).parents('tr').attr('data-column'));
                     }
                     if (search.length == 0) {
                         filterColumn($(this).parents('tr').attr('data-column'));
                     }
 
                     //    {changes by rajjak}
                     //show filter value
                     var label = $(this).parents('td').prev('td').text();
                     var value = $(this).val();
                     var data_title = label.replace(/\s/gm, '');
 
                     $(".filter_table_content[data-title='" + data_title + "']").text(label + ': ' + value);
 
                     // if (value == '') {
                     //     $("#apnd").html('');
                     // }
                     result = $(".filter_table_content[data-title='" + data_title + "']").text().split(':');
 
                     if (result[1] == ' ') {
                         $(".filter_table_content[data-title='" + data_title + "']").text('');
                     }
 
                 });
 
                 //for clear filter value
                 $('#clear').click(function() {
 
                     // changes by rajjak for clear filter jan 18, 2023
 
                     $("#col7_filter").val('');
                     $('#col7_filter').change();
 
                     $("#col10_filter").val('');
                     $('#col10_filter').change();
 
                     // $("#col12_filter").val('');
                     // $('#col12_filter').change();
 
                     $(".filter_table_content").text('');
 
                     $("#col5_filter").val('');
                     $('#col5_filter').change();
 
                    
                     // end
                     $('input.column_filter').val('');
                     $('input.column_filter').keyup(); //event trigger
 
                     $('input.global_filter').val('');
                     $('input.global_filter').keyup();
 
                     $('select.group_field').val('');
                     $('select.group_field').change();
 
                 });
 
                 //    {end}
 
                 // Changes By Akram
                 function saved_search_perform(savedSearchId) {
 
                     // $.urlParam = function(name){
                     //     var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                     //     return results[1] || 0;
                     // }
 
                     // // example.com?param1=name&param2=&id=6
                     // savedSearchId = $.urlParam('saved_query_id'); // name
                     // console.log(urlQ);
                     // $("#col3_filter").val("andy");
                     // console.log(savedSearchId);
 
                     $.ajax({
                         type: "post",
                         url: "/getSavedSearchQuery",
                         // cache: false,
                         // async: false,
                         data: {
                             saved_query_id: savedSearchId
                         },
                         success: function(response) {
 
                             if (response == "0") {
                                 console.log("Error to Save Search...");
                             } else {
                                 // console.log(response);
                                 result = Object.entries(response);
 
                                 result.forEach((res) => {
                                     if (res[0] !== 'top_filter') {
                                         console.log(res);
                                         $("#" + res[0]).val(res[1]);
                                         if (res[1].length >= 3) {
                                             filterColumn($("#" + res[0]).parents("tr").attr(
                                                 'data-column'));
                                         }
                                     }
                                 });
                             }
 
                         }
                     });
 
                 }
 
                 const urlParams = new URLSearchParams(location.search);
 
                 for (const [key, value] of urlParams) {
                     if (key == 'saved_query_id') {
                         console.log(`${key}:${value}`);
                         savedSearchId = value;
                         saved_search_perform(savedSearchId)
                     }
                 }
 
                 // End Akram Changes
 
 
 
                 var exists;
 
                 //function to call inside ajax callback 
                 function set_exists(x) {
                     exists = x;
                 }
 
                 // Add event listener for opening and closing details
                 $('#sample_data tbody').on('click', 'td.details-control', function() {
 
 
                     var tr = $(this).closest('tr');
                     var row = dataTable.row(tr);
 
                     var res;
                     //  alert(  row.find('td:eq(5)').html(data.OEmail));
                     var data_ids = $(this).data("id");
                     $.ajax({
                         type: "get",
                         url: "{{ route('live_search.update_record') }}",
                         cache: false,
                         async: false,
                         data: 'data_ids=' + data_ids,
                         success: function(response) {
 
                             if (response == "0") {
                                 set_exists(false);
                                 alert("Not Enough Credit to view");
                                 return false;
 
                             } else {
                                 set_exists(true);
                                 $('span.credit_counter').html(response);
                             }
 
                         }
                     });
                     if (exists == true)
 
                     {
 
                         if (row.child.isShown()) {
                             // This row is already open - close it
                             row.child.hide();
                             tr.removeClass('shown');
                             tr.find('td:eq(5)').html(row.data().Email);
                         } else {
                             // Open this row
                             row.child(format(row.data())).show();
                             tr.find('td:eq(5)').html(row.data().OEmail);
                             tr.addClass('shown');
                         }
                     }
                 });
 
             });
         </script>
         <script>
             $(document).ready(function() {
                 $('#postType a').click(function(e) {
                     e.preventDefault();
                     var goToUrl = $(this).attr('href');
                     redirect(goToUrl);
                 });
                 $('#orderBy').change(function() {
                     var goToUrl = $(this).val();
                     redirect(goToUrl);
                 });
             });
 
             @if (config('settings.optimization.lazy_loading_activation') == 1)
                 $(document).ready(function() {
                     $('#postsList').each(function() {
                         var $masonry = $(this);
                         var update = function() {
                             $.fn.matchHeight._update();
                         };
                         $('.item-list', $masonry).matchHeight();
                         this.addEventListener('load', update, true);
                     });
                 });
             @endif
         </script>
     @endsection