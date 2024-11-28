<main>
    <div class="container mt-5">

        <?php if (isset($error) && $error['error'] == true): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error['message'] ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error) && $error['error'] == false): ?>
            <div class="alert alert-success" role="alert">
                <?= $error['message'] ?>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Správa pozic</h2>

        <!-- Tlačítko pro vytvoření nové pozice -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createPositionModal" onclick="resetPositionForm()">
            <i class="fa fa-plus"></i> Přidat pozici
        </button>

        <!-- Tabulka pozic -->
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Název pozice</th>
                    <th>Admin?</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($positions as $position): ?>
                    <tr>
                        <td><?= $position['id'] ?></td>
                        <td><?= $position['name'] ?></td>
                        <td><?= $position['is_admin'] ? 'Ano' : 'Ne' ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#createPositionModal" 
                                onclick="editPosition(<?= $position['id'] ?>, '<?= $position['name'] ?>', <?= $position['is_admin'] ?>)">
                                <i class="fa fa-edit"></i> Upravit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Smazat
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modální okno pro vytvoření/úpravu pozice -->
    <div class="modal fade" id="createPositionModal" tabindex="-1" aria-labelledby="createPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPositionModalLabel">
                        <i class="fa fa-plus"></i> Přidat pozici
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                </div>
                <div class="modal-body">
                    <form id="positionForm" method="post" action="">
                        <input type="hidden" name="positionId" id="positionId">
                        <div class="mb-3">
                            <label for="positionName" class="form-label">Název pozice</label>
                            <input type="text" class="form-control" id="positionName" name="positionName" required>
                        </div>
                        <div class="mb-3">
                            <label for="admin">Je to admin?</label>
                            <select name="admin" id="admin" class="form-select">
                                <option value="0">Ne</option>
                                <option value="1">Ano</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                    <button type="submit" class="btn btn-success" form="positionForm">
                        <i class="fa fa-check"></i> Uložit
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function resetPositionForm() {
        document.getElementById('positionId').value = '';
        document.getElementById('positionName').value = '';
        document.getElementById('admin').value = '0';
        document.getElementById('createPositionModalLabel').textContent = 'Přidat pozici';
    }

    function editPosition(id, name, isAdmin) {
        document.getElementById('positionId').value = id;
        document.getElementById('positionName').value = name;
        document.getElementById('admin').value = isAdmin;
        document.getElementById('createPositionModalLabel').textContent = 'Upravit pozici';
    }
</script>