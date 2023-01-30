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

                    <div class="panel-body">
                        Data imported successfully.
                    </div>
                </div>
            </div>
        </div>
    </div>
			
@endsection
