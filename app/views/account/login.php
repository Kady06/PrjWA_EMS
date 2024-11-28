<main class="d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="container d-flex align-items-center justify-content-center">
        <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Přihlášení</h3>
            <form method="post" action="">
                <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $csrf_token ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Zadejte email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Heslo</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Zadejte heslo" required>
                    </div>
                </div>
                <h3 class="text-center mt-3"><?= isset($error) ? $error : "" ?></h3>
                <button type="submit" class="btn btn-primary w-100 mt-3">Přihlásit se</button>
            </form>
        </div>
    </div>
</main>