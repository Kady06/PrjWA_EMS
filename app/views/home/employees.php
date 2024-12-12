<main>
    <div class="container mt-5">

        <h2 class="mb-4">Seznam zaměstnanců</h2>

        <!-- Filtrace -->
        <form class="mb-3" id="filter_type">
            <div class="row">
                <div class="col-md-4">
                    <select class="form-select" name="filter_sort">
                        <option <?php if($sort == 'id') echo "selected" ?> value="">Výchozí řazení</option>
                        <option <?php if($sort == 'byNameAsc') echo "selected" ?> value="byNameAsc">Dle jména ABC</option>
                        <option <?php if($sort == 'byNameDesc') echo "selected" ?> value="byNameDesc">Dle jména ZYX</option>
                        <option <?php if($sort == 'bySurnameAsc') echo "selected" ?> value="bySurnameAsc">Dle příjmení ABC</option>
                        <option <?php if($sort == 'bySurnameDesc') echo "selected" ?> value="bySurnameDesc">Dle příjmení ZYX</option>
                        <option <?php if($sort == 'byEmailAsc') echo "selected" ?> value="byEmailAsc">Dle e-mailu AVC</option>
                        <option <?php if($sort == 'byEmailDesc') echo "selected" ?> value="byEmailDesc">Dle e-mailu ZYX</option>
                        <option <?php if($sort == 'bySalaryAsc') echo "selected" ?> value="bySalaryAsc">Dle platu od nejmenšího</option>
                        <option <?php if($sort == 'bySalaryDesc') echo "selected" ?> value="bySalaryDesc">Dle platu od největšího</option>
                        <option <?php if($sort == 'byPositionAsc') echo "selected" ?> value="byPositionAsc">Dle pozice ABC</option>
                        <option <?php if($sort == 'byPositionDesc') echo "selected" ?> value="byPositionDesc">Dle pozice ZYX</option>
                        <option <?php if($sort == 'byDepartmentAsc') echo "selected" ?> value="byDepartmentAsc">Dle oddělení ABC</option>
                        <option <?php if($sort == 'byDepartmentDesc') echo "selected" ?> value="byDepartmentDesc">Dle oddělení ZYX</option>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<script>
    document.querySelector('#filter_type').addEventListener('change', function() {
        let selected = document.querySelector('select[name="filter_sort"]').value;
        window.location.href = `/home/employees/${selected}`;
    });
</script>
