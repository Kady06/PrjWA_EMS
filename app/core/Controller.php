<?php

class Controller {


    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        $accountModel = $this->model('Account');
        $data['isLogged'] = $accountModel->isLogged();
        $data['logged'] = $accountModel->getLogged();        
        
        if(is_array($data)) {
            extract($data);
        }
        //var_dump($header[1]);
        require_once '../app/views/head.php';
        require_once '../app/views/header.php';
        require_once '../app/views/' . $view . '.php';
        require_once '../app/views/footer.php';
    }
}