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
            header('Location: /home/employees');
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

    public function register($data) {
        $emailToken = $data[0];

        $data = [
            'title' => 'EMS | Registrace',
        ];

        $checkedToken = $this->accountModel->checkRegisterToken($emailToken);

        if ($checkedToken) {
            $data['csrf_token'] = $this->getCsrfToken();
            $data['id_employee'] = $checkedToken['id_employee'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (!$this->checkCsrfToken($_POST['csrf_token'])) {
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                }
                if ($_POST['password'] !== $_POST['password2']) {
                    $data['error'] = 'Hesla se neshodují';
                }
                if (!isset($data['error'])) {
                    $data['error'] = $this->accountModel->passwordChange($_POST['id_employee'], $_POST['password'], $emailToken);
                }
            } else {
                $this->view('account/passwordChange', $data);
            }
        } else {
            header('Location: /');
        }

        

        
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