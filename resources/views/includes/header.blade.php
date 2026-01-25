<nav id="main-navbar" class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between position-relative">
        <div class="d-flex justify-content-start align-items-center">
            <div>
                <a class="navbar-brand" href="{{ route('home') }}">Tarot ?</a>
            </div>

            <div id="nav-brand-separator" class="position-absolute border-start"></div>

            <ul class="navbar-nav ms-4">
                <li class="nav-item me-2">
                    <a
                        class="nav-link rounded-1 {{ Route::currentRouteName() === 'home' ? 'active' : '' }}"
                        href="{{ route('home') }}"
                    >
                        <i class="fas fa-home me-1"></i> Accueil
                    </a>
                </li>

                <li class="nav-item me-2">
                    <a
                        class="nav-link rounded-1 {{ Route::currentRouteName() === 'players_index' ? 'active' : '' }}"
                        href="{{ route('players_index') }}"
                    >
                        <i class="fas fa-trophy"></i> Classement
                    </a>
                </li>

                <li class="nav-item me-2">
                    <a
                        class="nav-link rounded-1 {{ Route::currentRouteName() === 'hand_add' ? 'active' : '' }}"
                        href="{{ route('hand_add') }}"
                    >
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </a>
                </li>
            </ul>
        </div>

        <ul class="navbar-nav">
            <li class="nav-item me-2">
                <a
                    class="nav-link rounded-1 {{ Route::currentRouteName() === 'user_profile_index' ? 'active' : '' }}"
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
                    class="nav-link rounded-1 {{ Route::currentRouteName() === 'admin_index' ? 'active' : '' }}"
                    href="{{ route('admin_index') }}"
                >
                    <i class="fas fa-gear"></i> Admin
                </a>
            </li>
        </ul>
    </div>
</nav>
