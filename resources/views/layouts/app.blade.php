<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Server Monitoring System')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
</head>
<body class="bg-gray-100">

    {{-- Header include --}}
    @include('partials.header')

    {{-- Main content for the page --}}
    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>

    {{-- Optional footer --}}
    {{-- @include('partials.footer') --}}

    <script src="{{ asset('js/style.js') }}"></script>
</body>
</html>
