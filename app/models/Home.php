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
        $stmt = $this->db->prepare('INSERT INTO employees (name, surname, email, id_position, id_department) VALUES (:name, :surname, :email, :position, :department)');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':position', $data['position']);
        $stmt->bindParam(':department', $data['department']);
        $stmt->execute();

        // TODO: Heslo na email
        return ['error' => false, 'message' => 'Zaměstnanec byl úspěšně vytvořen.'];
        
    }
}
