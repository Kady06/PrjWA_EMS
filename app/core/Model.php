<?php
class Model {
    public function getDB() {
        return Database::getInstance()->getConnection();
    }
}