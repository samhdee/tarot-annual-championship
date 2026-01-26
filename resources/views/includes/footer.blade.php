<footer>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>Tarot ? &#169;</div>

            <ul class="navbar-nav">
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
</footer>
