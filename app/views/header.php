<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FFPokladna - credit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if(!isset($is_admin) || !$is_admin): ?>

                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <button type="button" class="btn btn-primary">Home</button>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">
                            <button type="button" class="btn btn-warning">Uživatelé</button>
                        </a>
                    </li>

                    <?php endif;?>

                    <li class="nav-item">
                        <a class="nav-link" href="/account/logout">
                            <button type="button" class="btn btn-danger">Odhlásit se</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>