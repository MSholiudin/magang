<!DOCTYPE html>
<html>
<head>
    <title>Laravel CRUD</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')

    <div class="container mt-4">
        @yield('content')
    </div>

    @include('layouts.footer')
</body>
</html>
