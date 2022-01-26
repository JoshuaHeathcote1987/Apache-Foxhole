<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" sizes="192x192" href="https://static.wixstatic.com/media/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png">
    <link rel="shortcut icon" href="https://static.wixstatic.com/media/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png" type="image/png"/>
    <link rel="apple-touch-icon" href="https://static.wixstatic.com/media/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png" type="image/png"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('css/mine.css')}}">
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
    @include('partials.navbar')
    <main>
        @auth
            @include('partials.sidebar')
            @include('partials.divider')
        @endauth
        @yield('content')
        @auth
            @include('partials.divider')
            @livewire('listgroup')
        @endauth
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/mine.js')}}"></script>
</body>
</html>