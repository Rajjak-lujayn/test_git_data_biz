@extends('admin::layouts.master')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
    <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
	<div class="row page-titles">
		<div class="col-md-6 col-12 align-self-center">
			<h2 class="mb-0">
				{{ 'Import'}}
			</h2>
		</div>
		<div class="col-md-6 col-12 align-self-center d-none d-md-block">
			<ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
				<li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
				<li class="breadcrumb-item active">{{ 'import' }}</li>
			</ol>
		</div>
	</div>
@endsection

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">CSV Import</div>
                    <div class="card text-black bg-warning mb-3 d-inline-block">
                        <div class="card-body">
                        <div class="card-header">CSV Rules</div>
                        <p class="card-text">
                            <ul>
                                <li>Header will be same for All CSV Import, make sure to copy below for header Name.</li>
                                <li>Suppose there new fields then make sure name will be in camelCase without space-special-character and then after new fields will be same with all new csv uploads.</li>
                                <li>If You Add into header name "FirstName" to "first name" then Script is consider new fields and create new into database and Get problem So please carefully make Sure with Same header name. </li>
                                <li>Make Sure Record will be Always Exist in New csv import otherwise that record will be keep into Trash. For Example, Rec-1# abc@gmail.com is exist in previous csv, but when new is not exist in new csv so Rec-1# will be goes into Trash.  </li>
                            </ul> 
                        </p>
                        </div>
                    </div>
                    <div class="card text-white bg-dark mb-3 d-inline-block">
                        <div class="card-body">
                        
                        <p class="card-text">Csv Header : FirstName,LastName,Title,CompanyName,Email,Phone1,Phone2,Website,EmployeeSize, Revenue,LinkedInPersonal,LinkedInCompany,Add1,Add2,City, State,Zip,Country,Industry,SubIndustry,SIC,NAICS,PersonLocation,CompanyEmployeeCount,CompanyFounded,CompanyHeadquarter
                        </p>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                                <div class="col-md-6">
                                    <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                                    @if ($errors->has('csv_file'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('csv_file') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="header" checked> File contains header row?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Parse CSV
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
			
@endsection
