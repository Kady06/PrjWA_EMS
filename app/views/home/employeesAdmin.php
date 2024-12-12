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

        <h2 class="mb-4">Detail a úprava zaměstnanců</h2>

        <!-- Tlačítko pro vytvoření zaměstnance -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createEmployeeModal">
            <i class="fa fa-user-plus"></i> Vytvořit zaměstnance
        </button>

        <!-- Filtrace -->
        <form class="mb-3" id="filter_type">
            <div class="row">
                <div class="col-md-4">
                    <select class="form-select" name="filter_sort">
                        <option <?php if ($sort == 'id') echo "selected" ?> value="">Výchozí řazení</option>
                        <option <?php if ($sort == 'byNameAsc') echo "selected" ?> value="byNameAsc">Dle jména ABC</option>
                        <option <?php if ($sort == 'byNameDesc') echo "selected" ?> value="byNameDesc">Dle jména ZYX</option>
                        <option <?php if ($sort == 'bySurnameAsc') echo "selected" ?> value="bySurnameAsc">Dle příjmení ABC</option>
                        <option <?php if ($sort == 'bySurnameDesc') echo "selected" ?> value="bySurnameDesc">Dle příjmení ZYX</option>
                        <option <?php if ($sort == 'byEmailAsc') echo "selected" ?> value="byEmailAsc">Dle e-mailu AVC</option>
                        <option <?php if ($sort == 'byEmailDesc') echo "selected" ?> value="byEmailDesc">Dle e-mailu ZYX</option>
                        <option <?php if ($sort == 'bySalaryAsc') echo "selected" ?> value="bySalaryAsc">Dle platu od nejmenšího</option>
                        <option <?php if ($sort == 'bySalaryDesc') echo "selected" ?> value="bySalaryDesc">Dle platu od největšího</option>
                        <option <?php if ($sort == 'byPositionAsc') echo "selected" ?> value="byPositionAsc">Dle pozice ABC</option>
                        <option <?php if ($sort == 'byPositionDesc') echo "selected" ?> value="byPositionDesc">Dle pozice ZYX</option>
                        <option <?php if ($sort == 'byDepartmentAsc') echo "selected" ?> value="byDepartmentAsc">Dle oddělení ABC</option>
                        <option <?php if ($sort == 'byDepartmentDesc') echo "selected" ?> value="byDepartmentDesc">Dle oddělení ZYX</option>
                    </select>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>E-mail</th>
                    <th>Plat</th>
                    <th>Pozice</th>
                    <th>Oddělení</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= $employee['id'] ?></td>
                        <td><?= $employee['name'] ?></td>
                        <td><?= $employee['surname'] ?></td>
                        <td><?= $employee['email'] ?></td>
                        <td><?= $employee['salary'] ?></td>
                        <td><?= $employee['position_name'] ?></td>
                        <td><?= $employee['department_name'] ?></td>
                        <td>
                            <!-- Upravit zaměstnance -->
                            <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"
                                data-id="<?= $employee['id'] ?>"
                                data-name="<?= $employee['name'] ?>"
                                data-surname="<?= $employee['surname'] ?>"
                                data-email="<?= $employee['email'] ?>"
                                data-position="<?= $employee['id_position'] ?>"
                                data-department="<?= $employee['id_department'] ?>"
                                data-salary="<?= $employee['salary'] ?>"
                                data-date="<?= $employee['start_date'] ?>">
                                <i class="fa fa-edit"></i> Upravit
                            </button>

                            <button type="submit" data-bs-target="#confirmationModal" onclick="selectDelete(<?= $employee['id'] ?>)" data-bs-toggle="modal" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Smazat
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modální okno pro vytvoření zaměstnanců -->
    <div class="modal fade" id="createEmployeeModal" tabindex="-1" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEmployeeModalLabel">
                        <i class="fa fa-user-plus"></i> Vytvořit nového zaměstnance
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                </div>
                <div class="modal-body">
                    <form id="employeeForm" method="post" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Jméno</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Příjmení</label>
                            <input type="text" class="form-control" id="surname" name="surname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Pozice</label>
                            <select class="form-select" id="position" name="position" required>
                                <option value="" disabled selected>Vyberte pozici</option>
                                <?php foreach ($positions as $position): ?>
                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Oddělení</label>
                            <select class="form-select" id="department" name="department" required>
                                <option value="" disabled selected>Vyberte oddělení</option>
                                <?php foreach ($departments as $department): ?>
                                    <option value="<?= $department['id'] ?>"><?= $department['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Plat</label>
                            <input type="number" class="form-control" id="salary" name="salary" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Datum nástupu</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                    <button type="submit" class="btn btn-success" form="employeeForm">
                        <i class="fa fa-check"></i> Uložit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modální okno pro úpravu zaměstnanců -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">
                        <i class="fa fa-user-edit"></i> Upravit zaměstnance
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                </div>
                <div class="modal-body">
                    <form id="editEmployeeForm" method="post" action="">
                        <input type="hidden" id="editEmployeeId" name="editEmployeeId">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Jméno</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSurname" class="form-label">Příjmení</label>
                            <input type="text" class="form-control" id="editSurname" name="surname" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPosition" class="form-label">Pozice</label>
                            <select class="form-select" id="editPosition" name="position" required>
                                <option value="" disabled selected>Vyberte pozici</option>
                                <?php foreach ($positions as $position): ?>
                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDepartment" class="form-label">Oddělení</label>
                            <select class="form-select" id="editDepartment" name="department" required>
                                <option value="" disabled selected>Vyberte oddělení</option>
                                <?php foreach ($departments as $department): ?>
                                    <option value="<?= $department['id'] ?>"><?= $department['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editSalary" class="form-label">Plat</label>
                            <input type="number" class="form-control" id="editSalary" name="salary" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDate" class="form-label">Datum nástupu</label>
                            <input type="date" class="form-control" id="editDate" name="date" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                    <button type="submit" class="btn btn-success" form="editEmployeeForm">
                        <i class="fa fa-check"></i> Uložit změny
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Potvrďte akci</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Opravdu chcete smazat uživatele?
                </div>
                <input type="hidden" name="deleteEmployeeId" id="deleteEmployeeId" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Ne</button>
                    <button type="submit" class="btn btn-danger" id="confirmButton">Ano</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // Skript pro předvyplnění modálního okna pro úpravu zaměstnanců
    document.querySelectorAll('.btn-primary').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('editEmployeeId').value = this.getAttribute('data-id');
            document.getElementById('editName').value = this.getAttribute('data-name');
            document.getElementById('editSurname').value = this.getAttribute('data-surname');
            document.getElementById('editEmail').value = this.getAttribute('data-email');
            document.getElementById('editPosition').value = this.getAttribute('data-position');
            document.getElementById('editDepartment').value = this.getAttribute('data-department');
            document.getElementById('editSalary').value = this.getAttribute('data-salary');
            document.getElementById('editDate').value = this.getAttribute('data-date');
        });
    });

    document.querySelector('#filter_type').addEventListener('change', function() {
        let selected = document.querySelector('select[name="filter_sort"]').value;
        window.location.href = '/home/employees/' + selected;
    });

    // Skript pro potvrzení smazání zaměstnance
    function selectDelete(id) {
        document.getElementById('confirmButton').addEventListener('click', function() {
            let deleteEmployeeId = document.querySelector('#deleteEmployeeId');
            deleteEmployeeId.value = id;
        });
    }
</script>