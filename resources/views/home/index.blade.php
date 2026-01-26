@php use App\Models\BgaUser;use App\Models\Hand; @endphp

@extends ('includes.layout')

@section('title', 'Accueil')

@section('vite_imports')
    @vite(['resources/scss/home.scss', 'resources/js/home.js'])
@endsection

@section ('content')
    <div id="scores-container">
        <h1>Classement actuel</h1>

        <article id="scores-list-wrapper" class="mt-4">
            <div id="scores-filters" class="d-flex ju">

            </div>

            <x-pagination/>

            <section class="mt-5">
                <table class="table table-bordered border-0">
                    {{--                    <thead>--}}
                    {{--                        <tr>--}}
                    {{--                            <th class="text-center" style="width: 7rem">--}}
                    {{--                                Date--}}
                    {{--                                <a href="#"><i class="fas fa-chevron-up ms-1 text-small"></i></a>--}}
                    {{--                            </th>--}}

                    {{--                            <th>Durée</th>--}}
                    {{--                            <th style="width: 15rem">Joueur.euse.s</th>--}}
                    {{--                            <th>Vainqueur.euse</th>--}}
                    {{--                            <th>Points</th>--}}
                    {{--                            <th style="width: 8rem"></th>--}}
                    {{--                        </tr>--}}
                    {{--                    </thead>--}}

                    <tbody>
                    @php /** @var BgaUser[] $players */ @endphp
                    @forelse ($players as $i => $player)
                        <tr @if ($i === 0) class="fw-bold fs-4" @endif>
                            <td>
                                @if ($i === 0)
                                    <i class="fas fa-trophy text-warning me-1"></i>
                                @endif

                                N°{{ $i + 1 }} : {{ $player->bga_username }}
                            </td>

                            <td>{{ $player->all_total_points }} points</td>

                            <td>{{ $player->handPlayers->pluck('gamePlayers')->flatten()->count() }}</td>

                            <td class="text-center">
                                <a class="p-1 btn btn-sm btn-primary" href="#" title="Voir le profil (bientôt)">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="text-muted text-center fst-italic">
                                    <i class="fas fa-ban me-1"></i> Aucun résultat
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </section>

            <div class="mt-5">
                <x-pagination/>
            </div>
        </article>
    </div>
@endsection
