@php
    use App\Models\Hand;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;
@endphp

@extends ('includes.layout')

@section('title', 'Accueil')

@section('vite_imports')
    @vite(['resources/js/admin.js'])
@endsection

@section ('content')
    <div id="scores-container">
        <h1>Dernières sessions</h1>

        <article id="scores-list-wrapper" class="mt-4">
            @include('history.list')
        </article>
    </div>
@endsection
