<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <base href="/" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>wayfinder</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cabin|Roboto&display=swap" rel="stylesheet">
{{--        prodswap--}}

        <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
        <script src="{{ ('js/app.js') }}" defer></script>
{{--        <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
        <link rel="manifest" href="./manifest.json"/>


    </head>
    <body>

        <div id="app">
            <index></index>
        </div>
    </body>
</html>
