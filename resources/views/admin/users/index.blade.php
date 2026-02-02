@extends('includes.layout')

@section('title') Admin @endsection

@section('vite_imports') @vite(['resources/js/admin.js']) @endsection

@section('content')
    <div id="admin-index-wrapper">
        <h2>Users</h2>

        <div id="admin-users">
            <table id="user-list-table" class="w-75 mx-auto mt-5 table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>BGA Username</th>
                        <th>Email</th>
                        <th>Dernière connexion</th>
                        <th>Actif.ve ?</th>
                        <th>Admin ?</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->bgaUser->id }}</td>
                            <td>{{ $user->bgaUser->bga_username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ !empty($user->last_login_at) ? $user->last_login_at->format('d/m/Y H:i:s') : 'Jamais' }}</td>

                            <td>
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input btn-action"
                                        type="checkbox"
                                        role="switch"
                                        name="active_state"
                                        data-url="{{ route('admin_users_active', [
                                            'user_id' => $user->id,
                                            'new_state' => empty($user->is_active) ? 1 : 0
                                        ]) }}"
                                        @if (!empty($user->is_active))
                                            checked
                                        @endif
                                        @if ($user->id === \Auth::user()->id)
                                            disabled
                                        @endif
                                    />
                                </div>
                            </td>

                            <td>
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input btn-action"
                                        type="checkbox"
                                        role="switch"
                                        name="admin_state"
                                        data-url="{{ route('admin_users_admin', [
                                            'bga_user_id' => $user->bgaUser->id,
                                            'new_state' => empty($user->bgaUser->is_admin) ? 1 : 0
                                        ]) }}"
                                        @if (!empty($user->bgaUser->is_admin))
                                            checked
                                        @endif
                                        @if ($user->id === \Auth::user()->id)
                                            disabled
                                        @endif
                                    />
                                </div>
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
        </div>
    </div>
@endsection
