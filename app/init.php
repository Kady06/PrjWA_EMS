<?php
header('Content-Type: text/html; charset=UTF-8');

setlocale(LC_ALL, 'cs_CZ.UTF-8');
date_default_timezone_set('Europe/Prague');


require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';