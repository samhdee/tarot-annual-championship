@php
    use App\Models\BgaUser;
@endphp

@props([
    /** @var int */
    'bga_user_id',
    /** @var string */
    'bga_username',
    /** @var int */
    'badge_width' => 25,
    /** @var bool */
    'dec_fs',
    /** @var bool */
    'show_name',
])

<a
    class="player-badge"
    href="{{ route('player_profile_index', $bga_user_id) }}"
>
    <img
        class="me-1"
        src="{{ BgaUser::getAvatar($bga_username) }}"
        width="{{ $badge_width }}"
        alt="{{ substr($bga_username, 0, 2) }}"
        title="{{ $bga_username }}"
    />

    @if ($show_name)
        @if (!empty($dec_fs) && strlen($bga_username) > 8)
            <span class="text-small">{{ $bga_username }}</span>
        @else
            {{ $bga_username }}
        @endif
    @endif
</a>
