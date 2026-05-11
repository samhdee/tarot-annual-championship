<div class="col-2">
    <div class="card">
        <div class="card-header text-center">Taux de victoire</div>

        <div class="card-body p-2 text-center">
            @if ($player['game_players']->isNotEmpty())
                {{ number_format(
                    100 * $player['victories']->count() / $player['game_players']->count(),
                    2,
                    ','
                ) }}%
                <br>
                ({{ $player['victories']->count() }} victoires)
            @else
                0%
                <br>
                (aucune victoire)
            @endif
        </div>
    </div>
</div>

<div class="col-2">
    <div class="card">
        <div class="card-header text-center">Score moyen</div>

        <div class="card-body text-center">
            {{ number_format($player['hands']->all_total_points / $player['game_players']->count(), 2, ',') }} pts
        </div>
    </div>
</div>

<div class="col-2">
    <div class="card">
        <div class="card-header text-center">Parties jouées</div>

        <div class="card-body text-center">{{ $player['game_players']->count() }}</div>
    </div>
</div>

{{--<div class="col-2">--}}
{{--    <div class="card">--}}
{{--        <div class="card-header text-center">Tendance</div>--}}

{{--        <div class="card-body text-center">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
