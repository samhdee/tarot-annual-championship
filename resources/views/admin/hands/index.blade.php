@extends('includes.layout')

@section('title')
    Admin
@endsection

@section('vite_imports')
    @vite(['resources/js/admin.js'])
@endsection

@section('content')
    <div id="admin-hands-wrapper">
        <h2>Parties</h2>

        <div id="admin-hands">
            <table id="hands-list-table" class="w-50 mx-auto mt-5 table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($hands as $hand)
                        <tr data-hand_id="{{ $hand->id }}">
                            <td class="text-center">{{ $hand->id }}</td>
                            <td>{{ $hand->started_at->format('d/m/Y') }}</td>
                            <td>{{ $hand->started_at->format('H:i:s') }}</td>

                            <td class="text-center">
                                <button
                                    role="button"
                                    class="btn btn-sm btn-danger btn-action"
                                    data-url="{{ route('admin_hands_delete', ['hand_id' => $hand->id]) }}"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="text-muted text-center fst-italic">
                                    <i class="fas fa-ban me-1"></i> Aucun résultat
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
