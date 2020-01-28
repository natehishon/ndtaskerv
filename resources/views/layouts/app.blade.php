<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel='manifest' href='/public/manifest.webmanifest'>
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

    <script>

        // This is the "Offline page" service worker

        // Add this below content to your HTML page, or add the js file to your page at the very top to register service worker

        // Check compatibility for the browser we're running this in
        if ("serviceWorker" in navigator) {
            if (navigator.serviceWorker.controller) {
                console.log("[PWA Builder] active service worker found, no need to register");
            } else {
                // Register the service worker
                navigator.serviceWorker
                    .register("pwabuilder-sw.js", {
                        scope: "./"
                    })
                    .then(function (reg) {
                        console.log("[PWA Builder] Service worker has been registered for scope: " + reg.scope);
                    });
            }
        }

        // This is the "Offline page" service worker

        const CACHE = "pwabuilder-page";

        // TODO: replace the following with the correct offline fallback page i.e.: const offlineFallbackPage = "offline.html";
        const offlineFallbackPage = "ToDo-replace-this-name.html";

        // Install stage sets up the offline page in the cache and opens a new cache
        self.addEventListener("install", function (event) {
            console.log("[PWA Builder] Install Event processing");

            event.waitUntil(
                caches.open(CACHE).then(function (cache) {
                    console.log("[PWA Builder] Cached offline page during install");

                    if (offlineFallbackPage === "ToDo-replace-this-name.html") {
                        return cache.add(new Response("TODO: Update the value of the offlineFallbackPage constant in the serviceworker."));
                    }

                    return cache.add(offlineFallbackPage);
                })
            );
        });

        // If any fetch fails, it will show the offline page.
        self.addEventListener("fetch", function (event) {
            if (event.request.method !== "GET") return;

            event.respondWith(
                fetch(event.request).catch(function (error) {
                    // The following validates that the request was for a navigation to a new document
                    if (
                        event.request.destination !== "document" ||
                        event.request.mode !== "navigate"
                    ) {
                        return;
                    }

                    console.error("[PWA Builder] Network request Failed. Serving offline page " + error);
                    return caches.open(CACHE).then(function (cache) {
                        return cache.match(offlineFallbackPage);
                    });
                })
            );
        });

        // This is an event that can be fired from your page to tell the SW to update the offline page
        self.addEventListener("refreshOffline", function () {
            const offlinePageRequest = new Request(offlineFallbackPage);

            return fetch(offlineFallbackPage).then(function (response) {
                return caches.open(CACHE).then(function (cache) {
                    console.log("[PWA Builder] Offline page updated from refreshOffline event: " + response.url);
                    return cache.put(offlinePageRequest, response);
                });
            });
        });


    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
