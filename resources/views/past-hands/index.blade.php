@php use App\Models\Hand; @endphp

@extends ('includes.layout')

@section('title', 'Accueil')

@section('vite_imports')
    @vite(['resources/scss/home.scss', 'resources/js/home.js'])
@endsection

@section ('content')
    <div id="scores-container">
        <h1>Dernières sessions</h1>

        <article id="scores-list-wrapper" class="mt-4">
            <x-pagination />

            <div id="scores-filters" class="d-flex ju">

            </div>

            <section class="mt-5">
                <table class="table table-bordered border-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 7rem">
                                Date
                                <a href="#"><i class="fas fa-chevron-up ms-1 text-small"></i></a>
                            </th>

                            <th>Durée</th>
                            <th style="width: 15rem">Joueur.euse.s</th>
                            <th>Vainqueur.euse</th>
                            <th>Points</th>
                            <th style="width: 8rem"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php /** @var Hand[] $hands */ @endphp
                        @forelse ($hands as $hand)
                            <tr>
                                <td class="text-center">{{ $hand->started_at->format('d/m/Y') }}</td>

                                <td>{{ ceil($hand->started_at->diffInMinutes($hand->ended_at)) }} minutes</td>

                                <td>
                                    @foreach ($hand->players->sortBy('bgaUser.bga_username') as $hand_player)
                                        <a class="me-1" href="#">
                                            <img
                                                src="{{ $hand_player->bgaUser->getAvatar() }}"
                                                width="25"
                                                class="player-badge"
                                                alt="{{ substr($hand_player->bgaUser->bga_username, 0, 2) }}"
                                            />
                                        </a>
                                    @endforeach
                                </td>

                                <td>
                                    <a href="#">
                                        {{ $hand->players->sortByDesc('total_points')->first()->bgaUser->bga_username }}
                                    </a>
                                </td>

                                <td>{{ $hand->players->first()->total_points }} points</td>

                                <td class="text-center">
                                    <a class="p-1 btn btn-sm btn-primary" href="#" title="Voir la session">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a class="ms-1 p-1 btn btn-sm btn-primary" href="#" title="Éditer la session">
                                        <i class="fas fa-pencil"></i>
                                    </a>

                                    <a class="ms-1 p-1 btn btn-sm btn-danger" href="#" title="Supprimer la session">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
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
                <x-pagination />
            </div>
        </article>
    </div>
@endsection
