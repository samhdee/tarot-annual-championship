<nav id="main-navbar" class="navbar navbar-expand-lg">
    <div class="container-fluid justify-content-between position-relative">
        <div class="d-flex justify-content-start align-items-center">
             @if (str_starts_with(Route::currentRouteName(), 'admin'))
                <div>
                    <a class="navbar-brand px-1" href="{{ route('home') }}" title="Retour au site">
                        <i class="fas fa-backward"></i>
                        <i class="far fa-house text-small"></i>
                    </a>
                </div>

                <div id="nav-brand-admin-separator" class="position-absolute border-start"></div>

                @include('includes.navbar-admin')
            @else
                <div>
                    <a class="navbar-brand" href="{{ route('home') }}">Tarot ?</a>
                </div>

                <div id="nav-brand-separator" class="position-absolute border-start"></div>

                @include('includes.navbar')
            @endif
        </div>

        <ul class="navbar-nav align-items-center">
            @guest
                <li class="nav-item dropdown">
                    <a
                        id="navbarDropdown"
                        class="nav-link dropdown-toggle rounded-1"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="fas fa-user"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Créer un compte</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a
                        class="nav-link {{ Route::currentRouteName() === 'user_profile_index' ? 'active' : '' }}"
                        href="{{ route('user_profile_index') }}"
                    >
                        <i class="fas fa-user"></i> {{ auth()->user()->bgaUser->bga_username }}
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('logout') }}"
                        title="Déconnexion"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        <i class="fas fa-arrow-right-from-bracket"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>
