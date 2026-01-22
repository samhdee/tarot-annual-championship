@extends ('includes.layout')

@section('title', 'Accueil')

@section('vite_imports')
    @vite(['resources/scss/home.scss'])
@endsection

@section ('content')
    <div id="scores-container">
        <h1>Tableau des scores</h1>

        <article id="scores-list-wrapper" class="mt-5">
            <section>
                <nav aria-label="Pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="Précédent">
                                <i aria-hidden="true" class="fas fa-step-backward"></i>
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="1">
                                1
                            </a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link d-inline" href="#" aria-current="page">
                                2
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="3">
                                3
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="Suivant">
                                <i aria-hidden="true" class="fas fa-step-forward"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </section>

            <section class="mt-4">
                <table class="table table-bordered border-0">
                    <thead>
                        <tr>
                            <th>Date <a href="#"><i class="fas fa-arrows-up-down"></i></a></th>
                            <th>Joueur.euse.s</th>
                            <th>Nombre de parties</th>
                            <th>Vainqueur.euse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>25/01</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>28/01</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>15/01</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="mt-4">
                <nav aria-label="Pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="Précédent">
                                <i aria-hidden="true" class="fas fa-step-backward"></i>
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="1">
                                1
                            </a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link d-inline" href="#" aria-current="page">
                                2
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="3">
                                3
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link d-inline" href="#" aria-label="Suivant">
                                <i aria-hidden="true" class="fas fa-step-forward"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </section>
        </article>
    </div>
@endsection
