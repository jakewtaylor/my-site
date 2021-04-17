<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @isset($title)
    <title>{{ $title }} - {{ env('APP_NAME') }}</title>
    @else
    <title>{{ env('APP_NAME') }}</title>
    @endisset

    {{-- <link rel="stylesheet" href="/css/style.css"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body
    class="h-full bg-blue-800 py-4 md:py-0 flex flex-col justify-between md:justify-center items-start md:items-center">
    @yield('content')
</body>

</html>