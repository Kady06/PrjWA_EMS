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

        <h2 class="mb-4">Správa oddělení</h2>

        <!-- Tlačítko pro vytvoření nového oddělení -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createDepartmentModal" onclick="resetDepartmentForm()">
            <i class="fa fa-plus"></i> Přidat oddělení
        </button>

        <!-- Tabulka oddělení -->
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Název oddělení</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                    <tr>
                        <td><?= $department['id'] ?></td>
                        <td><?= $department['name'] ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#createDepartmentModal" 
                                onclick="editDepartment(<?= $department['id'] ?>, '<?= $department['name'] ?>')">
                                <i class="fa fa-edit"></i> Upravit
                            </button>
                            <button class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteDepartmentModal" 
                                onclick="setDeleteId(<?= $department['id'] ?>)">
                                <i class="fa fa-trash"></i> Smazat
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modální okno pro vytvoření/úpravu oddělení -->
    <div class="modal fade" id="createDepartmentModal" tabindex="-1" aria-labelledby="createDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDepartmentModalLabel">
                        <i class="fa fa-plus"></i> Přidat/Upravit oddělení
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                </div>
                <div class="modal-body">
                    <form id="departmentForm" method="post" action="">
                        <input type="hidden" name="departmentId" id="departmentId">
                        <div class="mb-3">
                            <label for="departmentName" class="form-label">Název oddělení</label>
                            <input type="text" class="form-control" id="departmentName" name="departmentName" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                    <button type="submit" class="btn btn-success" form="departmentForm">
                        <i class="fa fa-check"></i> Uložit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modální okno pro potvrzení smazání -->
    <div class="modal fade" id="deleteDepartmentModal" tabindex="-1" aria-labelledby="deleteDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDepartmentModalLabel">
                        <i class="fa fa-trash"></i> Potvrzení smazání
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                </div>
                <div class="modal-body">
                    Opravdu chcete smazat toto oddělení?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="post" action="">
                        <input type="hidden" name="deleteId" id="deleteId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-check"></i> Smazat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function resetDepartmentForm() {
            document.getElementById('departmentId').value = '';
            document.getElementById('departmentName').value = '';
            document.getElementById('createDepartmentModalLabel').textContent = 'Přidat oddělení';
        }

        function editDepartment(id, name) {
            document.getElementById('departmentId').value = id;
            document.getElementById('departmentName').value = name;
            document.getElementById('createDepartmentModalLabel').textContent = 'Upravit oddělení';
        }

        function setDeleteId(id) {
            document.getElementById('deleteId').value = id;
        }
    </script>
</main>
