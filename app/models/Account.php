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
        return $_SESSION['account']['user_type'] == 'admin';
    }


    public function logout(): void
    {
        unset($_SESSION['account']);
        session_destroy();
        header('Location: /');
    }


    public function login(string $email, string $password): string
    {

        $stmt = $this->db->prepare('SELECT * FROM customers WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return 'Špatné jméno nebo heslo';
        }

        $_SESSION['account'] = $user;

        header('Location: /');
        return '';
    }

    public function register(string $name, string $surname, string $email, string $password, string $password2): string
    {
        if ($password != $password2) {
            return 'Hesla se neshodují';
        }

        $stmt = $this->db->prepare('SELECT * FROM customers WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            return 'Uživatel s tímto emailem již existuje';
        }

        $stmt = $this->db->prepare('INSERT INTO customers (name, surname, email, password, qr_code) VALUES (:name, :surname, :email, :password, :qr_code)');
        $stmt->execute([
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'qr_code' => '',
        ]);

        $this->login($email, $password);

        return '';
    }
}