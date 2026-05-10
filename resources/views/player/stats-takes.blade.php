<h3 class="text-center">Les prises</h3>

<div class="col-2">
    <div class="card">
        <div class="card-header">Taux de prise</div>

        <div class="card-body text-center">
            @if ($player['takes']->isNotEmpty())
                {{ number_format(
                    100 * $player['takes']->count() / $player['game_players']->count(),
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
        <div class="card-header">Taux de victoire</div>

        <div class="card-body text-center">
            @if ($player['game_players']->isNotEmpty())
                {{ number_format( 100 * $player['successful_takes']->count() / $player['takes']->count(), 2, ',' ) }}%
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
            {{ number_format($player['takes']->pluck('points')->sum() / $player['takes']->count(), 2, ',') }}
        </div>
    </div>
</div>

{{--    <div class="col-2">--}}
{{--        <div class="card">--}}
{{--            <div class="card-header">Tendance</div>--}}

{{--            <div class="card-body text-center">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
