<?php

class HomeController extends Controller {

    private $homeModel;
    private $accountModel;

    public function __construct() {
        $this->homeModel = $this->model('Home');
        $this->accountModel = $this->model('Account');
    }

    public function index() {
        if (!$this->accountModel->isLogged()) {
            header('Location: /account/login');
        }
        $data = [
            'title' => 'EMS | Domovská stránka',
            'is_admin' => $this->accountModel->isAdmin()
        ];

        $this->view('home/index', $data);
    }
}