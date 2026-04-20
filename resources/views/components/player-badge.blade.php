@php
    use App\Models\BgaUser;
@endphp

@props([
    /** @var int */
    'bga_user_id',
    /** @var string */
    'bga_username',
    /** @var bool */
    'dec_fs'
])

<a
    class="player-badge"
    href="{{ route('player_profile_index', $bga_user_id) }}"
>
    <img
            class="me-1"
            src="{{ BgaUser::getAvatar($bga_username) }}"
            width="25"
            alt="{{ substr($bga_username, 0, 2) }}"
    />
    @if ($dec_fs && strlen($bga_username) > 8)
        <span class="text-small">{{ $bga_username }}</span>
    @else
        {{ $bga_username }}
    @endif
</a>
