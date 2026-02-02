<footer>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>Tarot ? &#169;</div>

            @if (!str_starts_with(Route::currentRouteName(), 'admin'))
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a
                            class="nav-link rounded-1"
                            href="#"
                        >
                            <i class="fas fa-question-circle"></i> Aide
                        </a>
                    </li>

                    @can ('admin')
                        <li class="nav-item">
                            <a
                                class="nav-link rounded-1"
                                href="{{ route('admin_users') }}"
                            >
                                <i class="fas fa-gear"></i> Admin
                            </a>
                        </li>
                    @endcan
                </ul>
            @endif
        </div>
    </nav>
</footer>
