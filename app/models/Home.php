<?php 

class Home extends Model {
    private $db;

    public function __construct() {
        $this->db = $this->getDB();
    }

    
}