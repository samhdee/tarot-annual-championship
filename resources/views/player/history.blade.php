@php
    use Carbon\Carbon;
    use Illuminate\Support\Collection;
@endphp

<table id="player-history" class="mt-3 table table-bordered">
    <thead>
        <tr class="text-center align-middle" style="height: 3rem;">
            <th rowspan="2">Score</th>
            <th rowspan="2">Plis</th>
            <th colspan="4">Prise</th>
            <th rowspan="2" colspan="4">Autres joueur.euse.s</th>
            <th rowspan="2" style="width: 5rem;">Voir</th>
        </tr>

        <tr class="text-center align-middle" style="height: 3rem;">
            <th>Rôle</th>
            <th>Enchère</th>
            <th>Roi</th>
            <th>Chuté/<br>Réussi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($hand as $i => $game)
            <tr class="align-middle">
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
                        <x-bid-name :bga_bid_id="$game['bga_bid_id']"/>
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
                    <td class="text-start other-player-cell" style="width: 6rem;">
                        <div class="d-flex align-items-end">
                            <x-player-badge
                                :bga_user_id="$other_player->bga_user_id"
                                :bga_username="$other_player->bga_username"
                                :badge_width="40"
                                :show_name="false"
                            />

                            @if (
                                empty($game->is_goulash)
                                && (
                                    $other_player->role === $game->role
                                    || $other_player->role === 'taker_partner' && $game->role === 'taker'
                                    || $other_player->role === 'taker' && $game->role === 'taker_partner'
                            ))
                                <i class="text-small fas fa-handshake"></i>
                            @endif
                        </div>
                    </td>
                @endforeach

                <td>
                    <a class="btn btn-sm btn-primary"
                       href="{{ route('game_index', $game->game_id) }}">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
