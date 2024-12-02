<?php
class Model {
    public function getDB() {
        return Database::getInstance()->getConnection();
    }

    public function model(string $model): mixed {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }
}