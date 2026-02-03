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
        @csrf

        @include('includes.header')

        <main id="main-container" class="container mt-4">
            @if (session()->has('success'))
                <div class="w-75 mx-auto mb-2 alert alert-success alert-dissmisible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" aria-label="Fermer" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        @include('includes.footer')
    </div>
</body>
