<ul class="navbar-nav ms-4">
    <li class="nav-item">
        <a
            class="nav-link {{ Route::currentRouteName() === 'home' ? 'active' : '' }}"
            href="{{ route('home') }}"
        >
            <i class="fas fa-trophy me-1"></i> Classement
        </a>
    </li>

    <li class="nav-item">
        <a
            class="nav-link {{ Route::currentRouteName() === 'past_hands' ? 'active' : '' }}"
            href="{{ route('past_hands') }}"
        >
            <i class="fas fa-clock"></i> Historique
        </a>
    </li>

    @can ('active')
        <li class="nav-item">
            <a
                class="nav-link {{ Route::currentRouteName() === 'hand_add' ? 'active' : '' }}"
                href="{{ route('hand_add') }}"
            >
                <i class="fas fa-plus-circle"></i> Ajouter
            </a>
        </li>
    @endcan
</ul>
