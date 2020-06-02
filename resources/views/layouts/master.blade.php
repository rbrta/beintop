<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('/css/homepage.css') }}">
    @yield('styles')
</head>

<body>
    @include('parts.header')
   

    @yield('content')
    
    
    @include('parts.footer')

    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>