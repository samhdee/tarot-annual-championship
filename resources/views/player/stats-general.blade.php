<div class="mt-5 row justify-content-center gap-2">
    <div class="col-2">
        <div class="card">
            <div class="card-header text-center">Taux de victoire</div>

            <div class="card-body p-2 text-center">
                @if ($game_players->isNotEmpty())
                    {{ number_format(
                        100 * $victories->count() / $game_players->count(),
                        2,
                        ','
                    ) }}%
                    <br>
                    ({{ $victories->count() }} victoires)
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
                {{ number_format($hands->all_total_points / $game_players->count(), 2, ',') }} pts
            </div>
        </div>
    </div>

    <div class="col-2">
        <div class="card">
            <div class="card-header text-center">Parties jouées</div>

            <div class="card-body text-center">{{ $game_players->count() }}</div>
        </div>
    </div>

    {{--<div class="col-2">--}}
    {{--    <div class="card">--}}
    {{--        <div class="card-header text-center">Tendance</div>--}}

    {{--        <div class="card-body text-center">--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}
</div>

<div class="mt-5">
    <div class="text-center">Évolution des scores :</div>

    <canvas
        id="player-stats-points"
        class="mt-3 player-chart"
        data-values='@json($stats_scores)'
        data-title="Moyenne des points"
        data-type="line"
        data-unit="pts"
    ></canvas>
</div>
