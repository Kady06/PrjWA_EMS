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

    public function employees(): void {
        if (!$this->accountModel->isLogged() || !$this->accountModel->isAdmin()) {
            header('Location: /account/login');
        }
        $data = [
            'title' => 'EMS | Správa účtů',
            'is_logged' => $this->accountModel->isLogged(),
            'is_admin' => $this->accountModel->isAdmin()
        ];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['editEmployeeId']) && !empty($_POST['editEmployeeId'])) {
                $data['error'] = $this->homeModel->updateEmployee($_POST);
            } elseif ((!isset($_POST['editEmployeeId']) || empty($_POST['editEmployeeId'])) && !isset($_POST['deleteEmployeeId'])) {
                $data['error'] = $this->homeModel->createEmployee($_POST);
            } else {
                $data['error'] = $this->homeModel->deleteEmployee($_POST);
            }
        }

        $data['employees'] = $this->homeModel->getEmployees();
        $data['positions'] = $this->homeModel->getPositions();
        $data['departments'] = $this->homeModel->getDepartments();

        $this->view('home/employees', $data);
    }

    public function positions(): void {
        if (!$this->accountModel->isLogged() || !$this->accountModel->isAdmin()) {
            header('Location: /account/login');
        }
        $data = [
            'title' => 'EMS | Správa pracovních pozic',
            'is_logged' => $this->accountModel->isLogged(),
            'is_admin' => $this->accountModel->isAdmin()
        ];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['positionId']) && !empty($_POST['positionId'])) {
                $data['error'] = $this->homeModel->updatePosition($_POST);
            } elseif (isset($_POST['positionId']) && empty($_POST['positionId'])) {
                $data['error'] = $this->homeModel->createPosition($_POST);
            } else {
                $data['error'] = $this->homeModel->deletePosition($_POST);
            }
        }

        $data['positions'] = $this->homeModel->getPositions();

        $this->view('home/positions', $data);
    }

    public function departments(): void {
        if (!$this->accountModel->isLogged() || !$this->accountModel->isAdmin()) {
            header('Location: /account/login');
        }
        $data = [
            'title' => 'EMS | Správa oddělení',
            'is_logged' => $this->accountModel->isLogged(),
            'is_admin' => $this->accountModel->isAdmin()
        ];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['departmentId']) && !empty($_POST['departmentId'])) {
                $data['error'] = $this->homeModel->updateDepartment($_POST);
            } elseif (isset($_POST['departmentId']) && empty($_POST['departmentId'])) {
                $data['error'] = $this->homeModel->createDepartment($_POST);
            } else {
                $data['error'] = $this->homeModel->deleteDepartment($_POST);
            }
        }

        $data['departments'] = $this->homeModel->getDepartments();

        $this->view('home/departments', $data);
    }

}