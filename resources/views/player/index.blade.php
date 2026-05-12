@php
    use App\Enums\PlayerRoles;
    use App\Models\BgaUser;
    use App\Models\GamePlayer;
    use Carbon\Carbon;
    use Illuminate\Support\Collection;
    /** @var BgaUser $player */
    /** @var Collection[] $hands */
@endphp

@extends ('includes.layout')

@section('title', 'Profil de ' . $hands->bga_username)

@section('vite_imports')
    @vite(['resources/scss/player-profile.scss', 'resources/js/player-profile.js'])
@endsection

@section ('content')
    <div id="player-profile-container">
        <h2>{{ $hands->bga_username }}</h2>

        {{--        <div id="player-trophies-wrapper" class="mt-5 row justify-content-center gap-2">--}}
        {{--            --}}
        {{--        </div>--}}

        {{--        <hr class="mt-5 mb-4">--}}

        <div id="player-stats-wrapper">
            @include('player.stats-general')
        </div>

        <hr class="mt-5 mb-4">

        <div id="player-takes-wrapper" class="row justify-content-center gap-2">
            @include('player.stats-takes')
        </div>

        <hr class="mt-5 mb-4">

        <div id="player-defense-wrapper">
            @include('player.stats-defense')
        </div>

        <hr class="mt-5 mb-4">

        <div>
            <h3 class="text-center">Historique de parties</h3>

            @php
                $hands = $game_players->groupBy('game_started_at');
            @endphp

            <div class="mt-4 text-center fst-italic">
                <span class="me-1">Partie du</span>

                <select id="player-history-date" class="select2" style="width: 125px;">
                    @foreach($hands->keys() as $game_date)
                        <option value="{{ $game_date }}">
                            {{ Carbon::createFromFormat('Y-m-d', $game_date)->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="player-games-wrapper"></div>
        </div>
    </div>
@endsection
