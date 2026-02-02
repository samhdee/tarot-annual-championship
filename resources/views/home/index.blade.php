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
            <section class="mt-5 mx-auto w-50">
                <table class="table">
                    <tbody>
                        @php /** @var BgaUser[] $players */ @endphp
                        @forelse ($players as $i => $player)
                            <tr @if ($i === 0) class="fw-bold fs-4" @endif>
                                <td class="text-center">{{ $i + 1 }}</td>

                                <td>
                                    @if ($i === 0)
                                        <i class="fas fa-trophy text-warning me-1"></i>
                                    @endif

                                    <a href="#" title="Voir le profil (bientôt)">
                                        {{ $player->bga_username }}
                                    </a>
                                </td>

                                <td>{{ $player->all_total_points }} points</td>
                                <td>{{ $player->handPlayers->pluck('gamePlayers')->flatten()->count() }} parties</td>
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
        </article>
    </div>
@endsection
