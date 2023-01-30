@extends('admin.layout.master')
@section('title', 'Login')
@section('content')
    @if( request()->get('invalid_credentials') )
    <script>
        if (!alert("Invalid Credentials")) {
            window.location.href = "{{ $_ENV['APP_URL'] }}/login";
        }
    </script>
    @endif
    
    <div id="adminHome"></div>
@endsection