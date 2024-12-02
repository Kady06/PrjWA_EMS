<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Resetování hesla</h2>
            <form action="" method="POST">
                <!-- CSRF token -->
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <input type="hidden" name="id_employee" value="<?= $id_employee ?>">

                <!-- Heslo -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fa-solid fa-lock"></i> Nové heslo
                    </label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        placeholder="Zadejte nové heslo"
                        required 
                        pattern=".{8,}" 
                        title="Heslo musí mít alespoň 8 znaků"
                    >
                </div>

                <!-- Potvrzení hesla -->
                <div class="mb-3">
                    <label for="password2" class="form-label">
                        <i class="fa-solid fa-lock"></i> Potvrzení hesla
                    </label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password2" 
                        name="password2" 
                        placeholder="Zadejte heslo znovu"
                        required 
                        pattern=".{8,}" 
                        title="Heslo musí mít alespoň 8 znaků"
                    >
                </div>

                <!-- Odeslání -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Odeslat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>