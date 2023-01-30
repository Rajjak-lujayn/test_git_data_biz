@extends('install.layouts.master')

@section('title', trans('messages.cron_jobs'))

@section('content')

    <h3 class="title-3 text-success">
        <i class="icon-check"></i> Congratulations, you've successfully installed LaravelBizB2B(Classified Ads Web Application)
    </h3>

    Remember that all your configurations were saved in <strong class="text-bold">[APP_ROOT]/.env</strong> file. You can change it when needed.
	<br><br>
    Now, you can go to your Admin Panel with link:
    <a class="text-bold" href="{{ admin_url('login') }}">{{ admin_url() }}</a>.
    Visit your website: <a class="text-bold" href="{{ url('/') }}" target="_blank">{{ url('/') }}</a>
	<br><br>
	<a target="_blank" href="https://bit.ly/3zZZHeC">NULLED By NullJungle.com</a>.
    <br><br>
    Thank you for chosing LaraClassified. - <a class="text-bold" href="https://bedigit.com" target="_blank">bedigit.com</a>
    <div class="clearfix"></div>
    <br />

@endsection

@section('after_scripts')
@endsection
