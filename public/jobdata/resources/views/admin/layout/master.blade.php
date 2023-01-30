<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <script src="{{ env('APP_URLS') }}/public/js/app.js?v={{time()}}" defer></script>
    <link href="{{ env('APP_URLS') }}/public/css/app.css?v={{time()}}" defer rel="stylesheet" />
    <script src="https://kit.fontawesome.com/dd0190f9d8.js"></script>
</head>
<body>
    @yield('content')
</body>
</html>
