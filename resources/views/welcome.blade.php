<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="/"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>wayfinder</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin|Roboto&display=swap" rel="stylesheet">

    <script src="{{ ('js/app.js') }}" defer></script>

    {{--        prodswap--}}
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}

    <link rel="manifest" href="./manifest.json"/>
    <link href="https://vjs.zencdn.net/7.7.6/video-js.css" rel="stylesheet"/>

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script src="https://vjs.zencdn.net/7.7.6/video.js"></script>

</head>
<body>

<div id="app">
    <index></index>
</div>
</body>
</html>
