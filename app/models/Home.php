<?php

class Home extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = $this->getDB();
    }


    public function getEmployees(): array
    {
        $stmt = $this->db->prepare('SELECT employees.*, positions.name as position_name, departments.name as department_name FROM employees JOIN positions ON employees.id_position = positions.id JOIN departments ON employees.id_department = departments.id');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPositions(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM positions');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getDepartments(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM departments');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createEmployee(array $data): array
    {
        $data = array_map('htmlspecialchars', $data);
        $data = array_map('trim', $data);
        $data = array_map('stripslashes', $data);

        if (empty($data['name']) || empty($data['surname']) || empty($data['email']) || empty($data['position']) || empty($data['department'])) {
            return ['error' => true, 'message' => 'Všechna pole jsou povinná.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM employees WHERE email = :email');
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Zaměstnanec s tímto e-mailem již existuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM positions WHERE id = :id');
        $stmt->bindParam(':id', $data['position']);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Vybraná pozice neexistuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM departments WHERE id = :id');
        $stmt->bindParam(':id', $data['department']);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Vybrané oddělení neexistuje.'];
        }


        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['error' => true, 'message' => 'Zadejte platný e-mail.'];
        }

        if (strlen($data['name']) < 3 || strlen($data['name']) > 50) {
            return ['error' => true, 'message' => 'Jméno musí mít délku 3 až 50 znaků.'];
        }

        if (strlen($data['surname']) < 3 || strlen($data['surname']) > 50) {
            return ['error' => true, 'message' => 'Příjmení musí mít délku 3 až 50 znaků.'];
        }

        // salary
        if (!is_numeric($data['salary'])) {
            return ['error' => true, 'message' => 'Plat musí být číslo.'];
        }
        if ($data['salary'] < 0) {
            return ['error' => true, 'message' => 'Plat musí být kladné číslo.'];
        }

        // date
        $date = DateTime::createFromFormat('Y-m-d', $data['date']);
        if (!$date) {
            return ['error' => true, 'message' => 'Zadejte platné datum.'];
        }
        $stmt = $this->db->prepare('INSERT INTO employees (name, surname, email, id_position, id_department, salary, start_date) VALUES (:name, :surname, :email, :position, :department, :salary, :start_date)');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':position', $data['position']);
        $stmt->bindParam(':department', $data['department']);
        $stmt->bindParam(':salary', $data['salary']);
        $stmt->bindParam(':start_date', $data['date']);
        $stmt->execute();

        // TODO: Heslo na email
        return ['error' => false, 'message' => 'Zaměstnanec byl úspěšně vytvořen.'];
    }

    public function updateEmployee(array $data): array
    {
        $data = array_map('htmlspecialchars', $data);
        $data = array_map('trim', $data);
        $data = array_map('stripslashes', $data);

        if (empty($data['name']) || empty($data['surname']) || empty($data['email']) || empty($data['position']) || empty($data['department'])) {
            return ['error' => true, 'message' => 'Všechna pole jsou povinná.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM employees WHERE id = :id');
        $stmt->bindParam(':id', $data['editEmployeeId']);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Zaměstnanec neexistuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM employees WHERE email = :email AND id != :id');
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $data['editEmployeeId']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Zaměstnanec s tímto e-mailem již existuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM positions WHERE id = :id');
        $stmt->bindParam(':id', $data['position']);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Vybraná pozice neexistuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM departments WHERE id = :id');
        $stmt->bindParam(':id', $data['department']);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Vybrané oddělení neexistuje.'];
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['error' => true, 'message' => 'Zadejte platný e-mail.'];
        }

        if (strlen($data['name']) < 3 || strlen($data['name']) > 50) {
            return ['error' => true, 'message' => 'Jméno musí mít délku 3 až 50 znaků.'];
        }

        if (strlen($data['surname']) < 3 || strlen($data['surname']) > 50) {
            return ['error' => true, 'message' => 'Příjmení musí mít délku 3 až 50 znaků.'];
        }

        // salary
        if (!is_numeric($data['salary'])) {
            return ['error' => true, 'message' => 'Plat musí být číslo.'];
        }
        if ($data['salary'] < 0) {
            return ['error' => true, 'message' => 'Plat musí být kladné číslo.'];
        }

        // date
        $date = DateTime::createFromFormat('Y-m-d', $data['date']);
        if (!$date) {
            return ['error' => true, 'message' => 'Zadejte platné datum.'];
        }

        $stmt = $this->db->prepare('UPDATE employees SET name = :name, surname = :surname, email = :email, id_position = :position, id_department = :department, salary = :salary, start_date = :start_date WHERE id = :id');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':position', $data['position']);
        $stmt->bindParam(':department', $data['department']);
        $stmt->bindParam(':salary', $data['salary']);
        $stmt->bindParam(':start_date', $data['date']);
        $stmt->bindParam(':id', $data['editEmployeeId']);
        $stmt->execute();

        return ['error' => false, 'message' => 'Zaměstnanec byl úspěšně upraven.'];
    }

    public function deleteEmployee(array $data): array
    {
        if (empty($data['deleteId'])) {
            return ['error' => true, 'message' => 'ID zaměstnance je povinné.'];
        }

        $id = $data['deleteId'];

        $stmt = $this->db->prepare('SELECT * FROM employees WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Zaměstnanec neexistuje.'];
        }

        $stmt = $this->db->prepare('UPDATE employees SET deleted = true WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return ['error' => false, 'message' => 'Zaměstnanec byl úspěšně smazán.'];
    }

    public function createPosition(array $data): array
    {
        $data = array_map('htmlspecialchars', $data);
        $data = array_map('trim', $data);
        $data = array_map('stripslashes', $data);

        if (empty($data['positionName'])) {
            return ['error' => true, 'message' => 'Název pozice je povinný.'];
        }

        if (!isset($data['admin']) || $data['admin'] !== '1' || $data['admin'] !== '0') {
            return ['error' => true, 'message' => 'Je to admin? je povinné.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM positions WHERE name = :name');
        $stmt->bindParam(':name', $data['positionName']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Pozice s tímto názvem již existuje.'];
        }


        $stmt = $this->db->prepare('INSERT INTO positions (name, is_admin) VALUES (:name, :is_admin)');
        $stmt->bindParam(':name', $data['positionName']);
        $stmt->bindParam(':is_admin', $data['admin']);
        $stmt->execute();

        return ['error' => false, 'message' => 'Pozice byla úspěšně vytvořena.'];
    }

    public function updatePosition(array $data): array
    {
        $data = array_map('htmlspecialchars', $data);
        $data = array_map('trim', $data);
        $data = array_map('stripslashes', $data);

        if (empty($data['positionName'])) {
            return ['error' => true, 'message' => 'Název pozice je povinný.'];
        }

        if (!isset($data['admin']) || ($data['admin'] !== '1' && $data['admin'] !== '0')) {
            return ['error' => true, 'message' => 'Je to admin? je povinné.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM positions WHERE id = :id');
        $stmt->bindParam(':id', $data['positionId']);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Pozice neexistuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM positions WHERE name = :name AND id != :id');
        $stmt->bindParam(':name', $data['positionName']);
        $stmt->bindParam(':id', $data['positionId']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Pozice s tímto názvem již existuje.'];
        }

        $stmt = $this->db->prepare('UPDATE positions SET name = :name, is_admin = :is_admin WHERE id = :id');
        $stmt->bindParam(':name', $data['positionName']);
        $stmt->bindParam(':is_admin', $data['admin']);
        $stmt->bindParam(':id', $data['positionId']);
        $stmt->execute();

        return ['error' => false, 'message' => 'Pozice byla úspěšně upravena.'];
    }


    public function createDepartment(array $data): array
    {
        $data = array_map('htmlspecialchars', $data);
        $data = array_map('trim', $data);
        $data = array_map('stripslashes', $data);

        if (empty($data['departmentName'])) {
            return ['error' => true, 'message' => 'Název oddělení je povinný.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM departments WHERE name = :name');
        $stmt->bindParam(':name', $data['departmentName']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Oddělení s tímto názvem již existuje.'];
        }


        $stmt = $this->db->prepare('INSERT INTO departments (name) VALUES (:name)');
        $stmt->bindParam(':name', $data['departmentName']);
        $stmt->execute();

        return ['error' => false, 'message' => 'Oddělení bylo úspěšně vytvořeno.'];
    }

    public function updateDepartment(array $data): array
    {
        $data = array_map('htmlspecialchars', $data);
        $data = array_map('trim', $data);
        $data = array_map('stripslashes', $data);

        if (empty($data['departmentName'])) {
            return ['error' => true, 'message' => 'Název oddělení je povinný.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM departments WHERE id = :id');
        $stmt->bindParam(':id', $data['departmentId']);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Oddělení neexistuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM departments WHERE name = :name AND id != :id');
        $stmt->bindParam(':name', $data['departmentName']);
        $stmt->bindParam(':id', $data['departmentId']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Oddělení s tímto názvem již existuje.'];
        }

        $stmt = $this->db->prepare('UPDATE departments SET name = :name WHERE id = :id');
        $stmt->bindParam(':name', $data['departmentName']);
        $stmt->bindParam(':id', $data['departmentId']);
        $stmt->execute();

        return ['error' => false, 'message' => 'Oddělení bylo úspěšně upraveno.'];
    }

    public function deleteDepartment(array $data): array
    {

        if (empty($data['deleteId'])) {
            return ['error' => true, 'message' => 'ID oddělení je povinné.'];
        }

        $id = $data['deleteId'];

        $stmt = $this->db->prepare('SELECT * FROM departments WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return ['error' => true, 'message' => 'Oddělení neexistuje.'];
        }

        $stmt = $this->db->prepare('SELECT * FROM employees WHERE id_department = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Oddělení nelze smazat, protože obsahuje zaměstnance.'];
        }

        $stmt = $this->db->prepare('DELETE FROM departments WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return ['error' => false, 'message' => 'Oddělení bylo úspěšně smazáno.'];
    }
}
