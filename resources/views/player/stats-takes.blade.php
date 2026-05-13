<h3 class="text-center">Les prises</h3>

<div class="mt-4 row justify-content-center">
    <div class="col-2">
        <div class="card">
            <div class="card-header text-center">Taux de prise</div>

            <div class="card-body p-1 text-center">
                @if ($takes->isNotEmpty())
                    {{ number_format(
                        100 * $takes->count() / $game_players->count(),
                        2,
                        ','
                    ) }}%
                    <br>
                    ({{ $takes->count() }} prises)
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
                @if ($game_players->isNotEmpty())
                    {{ number_format(100 * $successful_takes->count() / $takes->count(), 2, ',') }}%
                    <br>
                    ({{ $successful_takes->count() }} victoires)
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
                {{ number_format($takes->pluck('points')->sum() / $takes->count(), 2, ',') }} pts
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

<div class="mt-5 row justify-content-between">
    <div class="col-5">
        <div>Victoires par type de contrat :</div>

        <canvas
            class="mt-3 player-chart"
            data-values='@json($stats_takes)'
            data-title="Pourcentage de réussite"
            data-type="bar"
            data-max="100"
            data-unit="%"
        ></canvas>
    </div>

    <div class="col-6">
        <div>Victoires par partenaire :</div>

        <canvas
            class="mt-3 player-chart"
            data-values='@json($stats_partners)'
            data-title="Pourcentage de réussite"
            data-type="bar"
            data-percentage="1"
            data-max="100"
            data-unit="%"
        ></canvas>
    </div>
</div>
