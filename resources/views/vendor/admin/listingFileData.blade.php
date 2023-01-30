@extends('admin::layouts.master')

@section('header')
    <div class="row page-titles">
        <div class="col-md-6 col-12 align-self-center">
            <h2 class="mb-0">
                <small id="tableInfo">{{ trans('admin.all') }}</small>
            </h2>
        </div>
        <div class="col-md-6 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
                <li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('listingFileName') }}</li>
            </ol>
        </div>
    </div>
@endsection
{{-- listing filename data for admin --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th scope="col">ID</th> --}}
                        <th scope="col">File Name</th>
                        <th scope="col">Count</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listingFileNameData as $fileData)
                        <tr>
                            {{-- <td>{{ $fileData->id }}</td> --}}
                            <td>{{ $fileData->file_name }}</td>
                            <td>{{ $fileData->count }}</td>
                            <td>{{ $fileData->created_at }}</td>
                            <td>
                                <a class="btn btn-danger" href="{{ route('fileDelete', $fileData->id) }}">Delete</a>
                                <a class="btn btn-primary" href="{{ route('download', $fileData->id) }}">Download</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection




@section('after_styles')
    {{-- DATA TABLES --}}
    <link href="{{ asset('vendor/admin-theme/plugins/datatables/css/jquery.dataTables.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('vendor/admin-theme/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
        rel="stylesheet" type="text/css" />
    <link
        href="{{ asset('vendor/admin-theme/plugins/datatables/extensions/Responsive/2.2.5/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endsection
