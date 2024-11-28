<?php

class AccountController extends Controller
{

    private $accountModel;

    public function __construct()
    {
        $this->accountModel = $this->model('Account');
    }

    public function login(): void
    {
        if ($this->accountModel->isLogged()) {
            header('Location: /');
        }
        $data = [
            'title' => 'EMS | Přihlášení',
        ];

        $data['csrf_token'] = $this->getCsrfToken();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->checkCsrfToken($_POST['csrf_token'])) {
                header('Location: ' . $_SERVER['REQUEST_URI']);
            }
            $data['error'] = $this->accountModel->login($_POST['email'], $_POST['password']);
        }

        $this->view('account/login', $data);
    }

    public function logout(): void
    {
        $this->accountModel->logout();
    }



    private function getCsrfToken(): mixed
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    private function checkCsrfToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}