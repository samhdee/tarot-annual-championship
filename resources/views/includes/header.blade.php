<nav id="main-navbar" class="navbar navbar-expand-lg">
    <div class="container-fluid justify-content-between">
        <div class="d-flex justify-content-start align-items-center position-relative">
            <div>
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-home me-1"></i> Tarot ?
                </a>
            </div>

            <div id="nav-brand-separator" class="position-absolute border-start"></div>

            <div id="header-page-title" class="ms-3 py-1 px-3 rounded-1">
                @yield('title')
            </div>
        </div>

        <ul class="navbar-nav">
            <li class="nav-item me-2">
                <a
                    class="nav-link rounded-1 {{ Route::current() === route('meet_add') ? 'active' : '' }}"
                    href="{{ route('meet_add') }}"
                >
                    <i class="fas fa-plus-circle"></i> Ajouter
                </a>
            </li>

            <li class="nav-item me-2">
                <a
                    class="nav-link rounded-1 {{ Route::current() === route('user_profile_index') ? 'active' : '' }}"
                    href="{{ route('players_index') }}"
                >
                    <i class="fas fa-trophy"></i> Classement
                </a>
            </li>

            <li class="nav-item me-2">
                <a
                    class="nav-link rounded-1 {{ Route::current() === route('user_profile_index') ? 'active' : '' }}"
                    href="{{ route('user_profile_index') }}"
                >
                    <i class="fas fa-user"></i> Profil
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link rounded-1"
                    href="#"
                >
                    <i class="fas fa-question-circle"></i> Aide
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link rounded-1 {{ Route::current() === route('admin_index') ? 'active' : '' }}"
                    href="{{ route('admin_index') }}"
                >
                    <i class="fas fa-gear"></i> Admin
                </a>
            </li>
        </ul>
    </div>
</nav>
