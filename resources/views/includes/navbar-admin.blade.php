<ul class="navbar-nav ms-3">
    <li class="nav-item">
        <a
            class="nav-link {{ Route::currentRouteName() === 'admin_users' ? 'active' : '' }}"
            href="{{ route('home') }}"
        >
            <i class="fas fa-user me-1"></i> Users
        </a>
    </li>

    <li class="nav-item">
        <a
            class="nav-link {{ Route::currentRouteName() === 'admin_hands' ? 'active' : '' }}"
            href="{{ route('admin_hands') }}"
        >
            <i class="fas fa-clock"></i> Parties
        </a>
    </li>
</ul>
