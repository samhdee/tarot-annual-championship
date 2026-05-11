<h3 class="text-center">Les prises</h3>

<div class="row justify-content-center">
    <div class="col-2">
        <div class="card">
            <div class="card-header text-center">Taux de prise</div>

            <div class="card-body p-1 text-center">
                @if ($player['takes']->isNotEmpty())
                    {{ number_format(
                        100 * $player['takes']->count() / $player['game_players']->count(),
                        2,
                        ','
                    ) }}%
                    <br>
                    ({{ $player['takes']->count() }} prises)
                @else
                    0%
                    <br>
                    (a pris 0 fois)
                @endif
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-header text-center">Taux de victoire</div>

            <div class="card-body p-1 text-center">
                @if ($player['game_players']->isNotEmpty())
                    {{ number_format(100 * $player['successful_takes']->count() / $player['takes']->count(), 2, ',') }}%
                    <br>
                    ({{ $player['successful_takes']->count() }} victoires)
                @else
                    0%
                @endif
            </div>
        </div>
    </div>

    <div class="col-2">
        <div class="card">
            <div class="card-header text-center">Score moyen</div>

            <div class="card-body text-center">
                {{ number_format($player['takes']->pluck('points')->sum() / $player['takes']->count(), 2, ',') }} pts
            </div>
        </div>
    </div>

    {{--    <div class="col-2">--}}
    {{--        <div class="card">--}}
    {{--            <div class="card-header text-center">Tendance</div>--}}

    {{--            <div class="card-body text-center">--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>

<div class="mt-4">
    <div>Victoires par type de contrat :</div>

    <canvas id="player-stats-takes" class="mt-3 player-chart" data-values='@json($player['stats_takes'])' data-title="Contrats"></canvas>
</div>
