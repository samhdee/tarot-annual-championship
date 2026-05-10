<div class="col-2">
    <div class="card">
        <div class="card-header">Taux de victoire</div>

        <div class="card-body text-center">
            @if ($player['game_players']->isNotEmpty())
                {{ number_format(
                    100 * $player['victories']->count() / $player['game_players']->count(),
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
            {{ number_format($player['hands']->all_total_points / $player['game_players']->count(), 2, ',') }}
        </div>
    </div>
</div>

<div class="col-2">
    <div class="card">
        <div class="card-header">Parties jouées</div>

        <div class="card-body text-center">{{ $player['game_players']->count() }}</div>
    </div>
</div>

{{--<div class="col-2">--}}
{{--    <div class="card">--}}
{{--        <div class="card-header">Tendance</div>--}}

{{--        <div class="card-body text-center">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
