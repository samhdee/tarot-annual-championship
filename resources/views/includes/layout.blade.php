<html>

<head>
    <meta charset="UTF-8" />
    <meta lang="fr" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - Tarot ?</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @yield('vite_imports')
</head>

<body>
    <div class="container">
        @include('includes.header')

        <main id="main-container" class="container mt-4">
            @yield('content')
        </main>
    </div>
</body>
