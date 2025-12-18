 <!DOCTYPE html>
 <html lang="en">
 <head>
    <title>Karsadia Management</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
 </head>
 <body>
    @include('partials.header')
    @include('partials.sidebar')
    <div class="content">
        @yield('content')
    </div>
 </body>
 </html>