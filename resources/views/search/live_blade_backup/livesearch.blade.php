{{--
 --}}
@extends('layouts.master')

@section('search')
	@parent
	@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.form', 'search.inc.form'])
@endsection

@section('content')
	<div class="main-container" id="search_result">
		
		
		<!--@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])-->
		<div class="search-form-results">
    		<div class="container">
    			<div class="row">
    
    				<!-- Sidebar -->
                    @if (config('settings.listing.left_sidebar'))
                       
    				    @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar', 'search.inc.sidebar'])
                        <?php $contentColSm = 'col-md-9'; ?>
                    @else
                        <?php $contentColSm = 'col-md-12'; ?>
                    @endif
    
    				<!-- Content -->
    				<div class="{{ $contentColSm }} page-content col-thin-left">
    				<div class="container">
    				<div class="card">
    				
    				<div class="card-body">
    					<div class="table-responsive">
    						<table id="sample_data" class="table table-bordered table-striped">
    							<thead>
    								<tr>
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
                                        <th>LinkedInCompany	</th>
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
    		
    		
    
    				<div style="clear:both;"></div>
    
    				<!-- Advertising -->
    				@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom', 'layouts.inc.advertising.bottom'])
    
    			</div>
    		</div>
		</div>
	</div>
@endsection



@section('modal_location')
	@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location', 'layouts.inc.modal.location'])
@endsection

@section('after_scripts')
<!-- JS, Popper.js, and jQuery -->
<script  src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
		<!-- CSS only -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

		
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>  
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
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

$( document ).ready(function() {
    $( ".dropdown-link-menu" ).click(function() {
    console.log( "ready!" );
        $( "#userMenuDropdown" ).toggle();
        
    });
});


function filterGlobal () {
    $('#sample_data').DataTable().search(
        $('#global_filter').val(),
        $('#global_regex').prop('checked'),
        $('#global_smart').prop('checked')
    ).draw();
}
 
function filterColumn ( i ) {
    $('#sample_data').DataTable().column( i ).search(
        $('#col'+i+'_filter').val(),
        $('#col'+i+'_regex').prop('checked'),
        $('#col'+i+'_smart').prop('checked')
    ).draw();
}
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.FirstName+' '+d.LastName+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Title:</td>'+
            '<td>'+d.Title+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td>Phone1 & Phone2:</td>'+
            '<td>'+d.Phone1+' & '+d.Phone2+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td>Website:</td>'+
            '<td>'+d.Website+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td>EmplyoeeSize:</td>'+
            '<td>'+d.EmplyoeeSize+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td>Revenue:</td>'+
            '<td>'+d.Revenue+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td>LinkedInCompany:</td>'+
            '<td>'+d.LinkedInCompany+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Industry:</td>'+
            '<td>'+d.Industry+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Country:</td>'+
            '<td>'+d.Country+'</td>'+
        '</tr>'+
       
    '</table>';
}

$(document).ready(function(){


	var dataTable = $('#sample_data').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"dom": '<"top">rt<"bottom"iflp><"clear">',
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "id", "visible": false },
            { "data": "FirstName" },
            { "data": "LastName" },
            { "data": "Title" },
            { "data": "Email" },
            { "data": "CompanyName" },
            { "data": "Phone1","visible": false  },
            { "data": "Phone2","visible": false  },
            { "data": "Website" ,"visible": false },
            { "data": "EmplyoeeSize","visible": false  },
            { "data": "Revenue","visible": false  },
            { "data": "LinkedInPersonal","visible": false  },
            { "data": "LinkedInCompany","visible": false  },
            { "data": "City","visible": false  },
            { "data": "State","visible": false  },
            { "data": "Zip","visible": false  },
            { "data": "Country","visible": false  },
            { "data": "Industry","visible": false  },
            { "data": "SubIndustry","visible": false  },
            { "data": "SIC","visible": false  },
            { "data": "NAICS","visible": false  }


        ],
		"ajax" : {
			url:"{{route('live_search.action')}}"
			//type:"POST"
		},
		  "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},

		 'iDisplayLength': 100
// 		,"fnServerData": function (sSource, aoData, fnCallback, oSettings) {
//             // aoData["country_list"] = 'United Kingdom';
//             console.log(aoData);
//             // oSettings.jqXHR = $.post(sSource, aoData, fnCallback, "json");
//         }
	});
    // onload 
    <?php if(isset($_GET["country_list"])):	?>
    dataTable.column(17).search("<?php echo implode(",",$_GET["country_list"]);?>").draw();
 <?php endif; if(isset($_GET["get_industries"])): ?>
    dataTable.column(18).search("<?php echo implode(",",$_GET["get_industries"]);?>").draw();
    <?php endif; if(isset($_GET["country_list"])):
    // print_r($_GET["country_list"]);
    foreach($_GET["country_list"] as $country):
    ?> 
    
    var $newOption = $("<option selected='selected'></option>").val("<?php echo $country; ?>").text("<?php echo $country; ?>")
 
    $("#get_countries").append($newOption).trigger('change');
    
    <?php endforeach; endif; ?>
     <?php if(isset($_GET["get_industries"])):
    // print_r($_GET["country_list"]);
    foreach($_GET["get_industries"] as $ind):
    ?> 
    
     var $newOption = $("<option selected='selected'></option>").val("<?php echo $ind; ?>").text("<?php echo $ind; ?>")
 
    $("#get_industry").append($newOption).trigger('change');
    <?php endforeach; endif; ?>

    $('#searchButton').click(function () {
       
       dataTable.column(18).search($("#get_industry").val()).column(17).search($("#get_countries").val()).draw();

       // dataTable.search($("#get_industry").val()).draw();
    });

    $('#get_industry').change(function () {
         dataTable.column(18).search($("#get_industry").val()).column(17).search($("#get_countries").val()).draw();
   });

    $('#get_countries').change(function () {
       
       dataTable.column(18).search($("#get_industry").val()).column(17).search($("#get_countries").val()).draw();

       
    });
	

	$('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    } );
 
    $('input.column_filter').on( 'keyup click', function () {
       // filterColumn( $(this).parents('tr').attr('data-column') );
        var search = $(this).val();
            if(search.length >= 3 || search.length == 0)
            { 
        filterColumn( $(this).parents('tr').attr('data-column') );
            }
    } );
	
    // Add event listener for opening and closing details
    $('#sample_data tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dataTable.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

});	
</script>
	<script>
		$(document).ready(function () {
			$('#postType a').click(function (e) {
				e.preventDefault();
				var goToUrl = $(this).attr('href');
				redirect(goToUrl);
			});
			$('#orderBy').change(function () {
				var goToUrl = $(this).val();
				redirect(goToUrl);
			});
		});
		
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
