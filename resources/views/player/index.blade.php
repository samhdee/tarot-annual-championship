@php
    use App\Models\BgaUser;
    /** @var BgaUser $player */
@endphp

@extends ('includes.layout')

@section('title', 'Profil joueur')

@section('vite_imports')
    @vite(['resources/scss/player-profile.scss'])
@endsection

@section ('content')
    <div id="player-container">
        <h2>{{ $player->bga_username }}</h2>

{{--        <div id="player-trophies-wrapper" class="mt-5 row justify-content-center gap-2">--}}
{{--            --}}
{{--        </div>--}}

{{--        <hr class="my-5 mx-auto w-75">--}}

        <div id="player-stats-wrapper" class="mt-5 row justify-content-center gap-2">
            <div class="col-2">
                <div class="card">
                    <div class="card-header">Taux de victoire</div>

                    <div class="card-body text-center">
                        @if ($player->gamePlayers['victories']->isNotEmpty() && $player->gamePlayers['games']->isNotEmpty())
                            {{ number_format(
                                100 * $player->gamePlayers['victories']->count() / $player->gamePlayers['games']->count(),
                                2
                            ) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="card">
                    <div class="card-header">Score moyen</div>

                    <div class="card-body text-center">103</div>
                </div>
            </div>

            <div class="col-2">
                <div class="card">
                    <div class="card-header">Parties jouées</div>

                    <div class="card-body text-center">125</div>
                </div>
            </div>

            <div class="col-2">
                <div class="card">
                    <div class="card-header">Tendance</div>

                    <div class="card-body text-center">
                        <i class="fas fa-arrow-trend-up"></i>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5 mx-auto w-75">

        <div id="player-takes-wrapper" class="mt-5">
            <h3>Les prises</h3>
        </div>

        <div id="player-defense-wrapper" class="mt-5">
            <h3>La défense</h3>
        </div>

        <div id="player-games-wrapper" class="mt-5">
            <h3>Historique de parties</h3>
        </div>
    </div>
@endsection
