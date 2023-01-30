@extends('layout.master')
@section('title','Home')
@section('content')
    @if (request()->get('welcome'))
        <script>
            if (!alert("Email Varified Successfully {{ request()->get('welcome') }}")) {
                window.location.href = "/jobdata";
            }
        </script>
    @endif
    <div id="root"></div>
@endsection
