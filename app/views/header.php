<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EMS - Projekt na WA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (!isset($is_logged) || !$is_logged): ?>


                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/home">
                                <button type="button" class="btn btn-primary">Můj účet</button>
                            </a>
                        </li>
                        <?php if (!isset($is_admin) || !$is_admin): ?>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/home/employees">
                                    <button type="button" class="btn btn-warning">Správa účtů</button>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/home/positions">
                                    <button type="button" class="btn btn-info">Pracovní pozice</button>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/home/departments">
                                    <button type="button" class="btn btn-info">Oddělení</button>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/account/logout">
                                <button type="button" class="btn btn-danger">Odhlásit se</button>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>