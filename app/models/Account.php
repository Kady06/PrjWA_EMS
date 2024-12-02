<?php

class Account extends Model
{

    private $db;

    public function __construct()
    {
        $this->db = $this->getDB();
    }

    public function isLogged(): bool
    {
        return isset($_SESSION['account']);
    }

    public function getLogged(): mixed
    {
        if (!$this->isLogged()) {
            return null;
        }
        return $_SESSION['account'];
    }

    public function isAdmin(): bool
    {
        if (!$this->isLogged()) {
            return false;
        }
        return $_SESSION['account']['is_admin'] == 1;
    }


    public function logout(): void
    {
        unset($_SESSION['account']);
        session_destroy();
        header('Location: /');
    }


    public function login(string $email, string $password): string
    {

        $stmt = $this->db->prepare('SELECT employees.*, positions.is_admin FROM employees JOIN positions ON employees.id_position = positions.id WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return 'Špatné jméno nebo heslo';
        }

        $_SESSION['account'] = $user;

        header('Location: /');
        return '';
    }

    public function passwordChange($id, $password, $token): void
    {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare('UPDATE employees SET password = :password WHERE id = :id');
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt = $this->db->prepare('UPDATE password_resets SET used = 1 WHERE token = :token');
        $stmt->execute(['token' => $token]);

        header('Location: /');
    }


    public function checkRegisterToken(string $token): mixed
    {
        $stmt = $this->db->prepare('SELECT * FROM password_resets WHERE token = :token AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR) AND used = 0');
        $stmt->execute(['token' => $token]);
        $token = $stmt->fetch();

        if (!$token) {
            return false;
        }

        return $token;
    }
}
