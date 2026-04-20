@php
    use App\Enums\PlayerRoles;
    use App\Models\BgaUser;
    use App\Models\GamePlayer;
    use Carbon\Carbon;
    use Illuminate\Support\Collection;
    /** @var BgaUser $player */
@endphp

@extends ('includes.layout')

@section('title', 'Profil de ')

@section('vite_imports')
    @vite(['resources/scss/player-profile.scss'])
@endsection

@section ('content')
    <div id="player-profile-container">
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

            <table id="player-history" class="mt-4 table table-bordered">
                <thead>
                    <tr class="text-center align-middle" style="height: 3rem;">
                        <th rowspan="2" style="width: 5.5rem;">Date</th>
                        <th rowspan="2" style="width: 8rem;">Score</th>
                        <th rowspan="2" style="width: 3rem;">Plis</th>
                        <th colspan="4">Prise</th>
                        <th rowspan="2" colspan="4">Autres joueur.euse.s</th>
                        <th rowspan="2">Voir</th>
                    </tr>

                    <tr class="text-center align-middle" style="height: 3rem;">
                        <th style="width: 5.5rem;">Rôle</th>
                        <th style="width: 5.5rem;">Enchère</th>
                        <th style="width: 3rem;">Roi</th>
                        <th style="width: 5rem;">Chuté/<br>Réussi</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        /** @var Collection[] $hands */
                        $hands = $player['games']->groupBy('game_started_at');
                    @endphp

                    @foreach ($hands as $game_started_at => $games)
                        @foreach ($games as $i => $game)
                            <tr class="align-middle">
                                @if ($i === 0)
                                    <td
                                        class="align-middle"
                                        rowspan="{{ $games->count() }}"
                                    >
                                        {{ Carbon::createFromFormat('Y-m-d', $game_started_at)->format('d/m/Y') }}
                                    </td>
                                @endif

                                <td
                                    id="game-{{ $game->game_id }}"
                                    class="text-center"
                                    title="{{ Carbon::createFromFormat('Y-m-d H:i:s', $game->started_at)->format('H:i:s') }}"
                                >
                                    @if (intval($game->points) > 0)
                                        <i class="fs-5 fas fa-trophy text-warning me-1"></i>
                                        <span class="fw-bold">{{ $game->points }}&nbsp;pts</span>
                                    @else
                                        <span class="text-danger">{{ $game->points }}&nbsp;pts</span>
                                    @endif
                                </td>

                                <td>{{ $game->nb_tricks }}</td>

                                @if (!empty($game->role) && in_array($game->role, ['taker', 'taker_partner']))
                                    <td>
                                        <x-player_role :role="$game->role"/>
                                    </td>

                                    <td>
                                        <x-bid-name :bga_bid_id="$game['bga_bid_id']" />
                                    </td>

                                    <td>
                                        <x-king_colour :king_colour="$game->king_colour"/>
                                    </td>

                                    <td class="@if ($game->contract_points_diff > 0)
                                        fw-bold
                                    @elseif (intval($game->points) > 0)
                                        text-danger
                                    @endif">
                                        {{ $game->contract_points_diff }} pts
                                    </td>
                                @elseif (!empty($game->is_goulash))
                                    <td colspan="4">Goulash</td>
                                @else
                                    <td colspan="4">Défense</td>
                                @endif

                                @foreach ($game->other_players as $other_player)
                                    <td class="ps-1 pe-2 text-end other-player-cell" style="width: 9.5rem;">
                                        @if (
                                            empty($game->is_goulash)
                                            && (
                                                $other_player->role === $game->role
                                                || $other_player->role === 'taker_partner' && $game->role === 'taker'
                                                || $other_player->role === 'taker' && $game->role === 'taker_partner'
                                        ))
                                            🤝
                                        @endif

                                        <x-player-badge
                                            :bga_user_id="$other_player->bga_user_id"
                                            :bga_username="$other_player->bga_username"
                                            :dec_fs="true"
                                        />
                                    </td>
                                @endforeach

                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ route('game_index', $game->game_id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
