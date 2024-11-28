<?php

class HomeController extends Controller {

    private $homeModel;
    private $accountModel;

    public function __construct() {
        $this->homeModel = $this->model('Home');
        $this->accountModel = $this->model('Account');
    }

    public function index(): void {
        if (!$this->accountModel->isLogged()) {
            header('Location: /account/login');
        }
        $data = [
            'title' => 'EMS | Domovská stránka',
            'is_logged' => $this->accountModel->isLogged(),
            'is_admin' => $this->accountModel->isAdmin()
        ];

        $this->view('home/index', $data);
    }

    public function admin(): void {
        if (!$this->accountModel->isLogged() || !$this->accountModel->isAdmin()) {
            header('Location: /account/login');
        }
        $data = [
            'title' => 'EMS | Správa účtů',
            'is_logged' => $this->accountModel->isLogged(),
            'is_admin' => $this->accountModel->isAdmin()
        ];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $createEmployee = $this->homeModel->createEmployee($_POST);
        }

        $data['employees'] = $this->homeModel->getEmployees();
        $data['positions'] = $this->homeModel->getPositions();
        $data['departments'] = $this->homeModel->getDepartments();

        $this->view('home/admin', $data);
    }
}