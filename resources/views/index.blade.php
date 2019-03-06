<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Time Sheet</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Icons -->
        <link href="{{ asset('css/themify-icons/themify-icons.css') }}" rel="stylesheet" type="text/css">
        
        <!-- Styles -->
        <link href="{{ mix('css/tooltip.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    
    </head>
    <body>
        <div id="app">
            <App />
        </div>

        <!-- Scripts -->
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
