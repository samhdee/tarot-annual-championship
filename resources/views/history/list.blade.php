@php
    use App\Models\Hand;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    /** @var LengthAwarePaginator $hands */
@endphp

@if ($hands->hasPages())
    <x-pagination links="{{ $hands->links() }}"/>
@endif

<section id="history-list-wrapper" class="mt-5">
    <table class="table table-bordered align-middle border-0">
        <thead>
            <tr>
                <th class="text-center" style="width: 7rem">
                    Date

                    <a
                        class="btn-action text-light"
                        href="#"
                        data-ajax_url="{{ route('hand_sort', ['direction' => $sort === 'desc' ? 'asc' : 'desc']) }}"
                        data-view_container="#history-list-wrapper"
                    >
                        @if ($sort === 'desc')
                            <i class="fas fa-chevron-up ms-1 text-small"></i>
                        @else
                            <i class="fas fa-chevron-down ms-1 text-small"></i>
                        @endif
                    </a>
                </th>

                <th>Durée</th>
                <th>Lien</th>
                <th style="width: 15rem">Joueur.euse.s</th>
                <th>Vainqueur.euse</th>
                <th>Points</th>
                <th style="width: 8rem"></th>
            </tr>
        </thead>

        <tbody>
        @php /** @var Hand $hand */ @endphp
        @forelse ($hands as $hand)
            <tr>
                <td class="text-center">{{ $hand->started_at->format('d/m/Y') }}</td>
                <td>{{ ceil($hand->started_at->diffInMinutes($hand->ended_at)) }} minutes</td>
                <td>
                    <a href="{{ $hand->getBgaLink() }}" target="_blank">
                        #{{ $hand->bga_hand_id }}
                    </a>
                </td>

                <td>
                    @foreach ($hand->players->sortBy('bgaUser.bga_username') as $hand_player)
                        <a class="me-1 player-badge" href="#">
                            <img
                                src="{{ $hand_player->bgaUser->getAvatar() }}"
                                width="25"
                                alt="{{ substr($hand_player->bgaUser->bga_username, 0, 2) }}"
                            />
                        </a>
                    @endforeach
                </td>

                <td>
                    @php
                        $winner = $hand->players->sortByDesc('total_points')->first();
                    @endphp

                    <a class="player-badge" href="#">
                        <img
                            class="me-2"
                            src="{{ $winner->bgaUser->getAvatar() }}"
                            width="40"
                            alt="{{ substr($winner->bgaUser->bga_username, 0, 2) }}"
                        />

                        {{ $winner->bgaUser->bga_username }}
                    </a>
                </td>

                <td>{{ $hand->players->first()->total_points }} points</td>

                <td class="text-center">
                    <a class="p-1 btn btn-sm btn-primary" href="#" title="Voir la session">
                        <i class="fas fa-eye"></i>
                    </a>

                    @can ('admin')
                        <a class="ms-1 p-1 btn btn-sm btn-primary" href="#" title="Éditer la session">
                            <i class="fas fa-pencil"></i>
                        </a>

                        <a class="ms-1 p-1 btn btn-sm btn-danger" href="#" title="Supprimer la session">
                            <i class="fas fa-trash"></i>
                        </a>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <div class="text-muted text-center fst-italic">
                        <i class="fas fa-ban me-1"></i> Aucun résultat
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</section>

@if ($hands->hasPages())
    <div class="mt-5">
        <x-pagination links="{{ $hands->links() }}"/>
    </div>
@endif
