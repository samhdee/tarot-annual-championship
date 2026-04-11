@php
    use App\Models\BgaUser;
    use App\Models\GamePlayer;use Carbon\Carbon;use Illuminate\Support\Collection;
    /** @var BgaUser $player */
@endphp

@extends ('includes.layout')

@section('title', 'Profil joueur')

@section('vite_imports')
    @vite(['resources/scss/player-profile.scss'])
@endsection

@section ('content')
    <div id="player-container">
        <h2>{{ $player['hands']->bga_username }}</h2>

        {{--        <div id="player-trophies-wrapper" class="mt-5 row justify-content-center gap-2">--}}
        {{--            --}}
        {{--        </div>--}}

        {{--        <hr class="my-5 mx-auto w-75">--}}

        <div id="player-stats-wrapper" class="mt-5 row justify-content-center gap-2">
            <div class="col-2">
                <div class="card">
                    <div class="card-header">Taux de victoire</div>

                    <div class="card-body text-center">
                        @if ($player['victories']->isNotEmpty() && $player['games']->isNotEmpty())
                            {{ number_format(
                                100 * $player['victories']->count() / $player['games']->count(),
                                2,
                                ','
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

                    <div class="card-body text-center">
                        {{ number_format($player['hands']->all_total_points / $player['games']->count(), 2, ',') }}
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="card">
                    <div class="card-header">Parties jouées</div>

                    <div class="card-body text-center">{{ $player['games']->count() }}</div>
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

            <table id="player-history" class="table table-bordered">
                <thead>
                    <tr class="text-center align-middle" style="height: 3rem;">
                        <th style="width: 5rem;" rowspan="2">Date</th>
                        <th style="width: 10rem;" rowspan="2">Score</th>
                        <th rowspan="2">Partenaire(s)</th>
                        <th rowspan="2">Adversaires</th>
                        <th rowspan="2">Plis</th>
                        <th colspan="3">Prise</th>
                    </tr>

                    <tr class="text-center align-middle" style="height: 3rem;">
                        <th style="width: 5.5rem;">A pris ?</th>
                        <th style="width: 7rem;">Roi appelé</th>
                        <th style="width: 10rem;">Chutée/réussie de...</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        /** @var Collection[] $game_players */
                        $game_players = $player['games']->groupBy('game_started_at');
                        dump($game_players->toArray());
                    @endphp

                    @foreach ($game_players as $game_started_at => $games)
                        @foreach($games as $i => $game)
                            <tr>
                                @if ($i === 0)
                                    <td class="align-middle" rowspan="{{ $games->count() }}">
                                        {{ Carbon::createFromFormat('d-m-Y', $game_started_at)->format('d/m/Y') }}
                                    </td>
                                @endif

                                <td id="game-{{ $game->game_id }}" class="text-center">
                                    @if (intval($game->points) > 0)
                                        <i class="fs-5 fas fa-trophy text-warning me-1"></i>
                                        <span class="fw-bold">{{ $game->points }} points</span>
                                    @else
                                        <span class="text-danger">{{ $game->points }} points</span>
                                    @endif
                                </td>

                                <td>
{{--                                    @if ($game->)--}}
                                </td>

                                <td>
                                    {{--                                    @foreach ($game->pluck())--}}

                                    {{--                                    @endforeach--}}
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
