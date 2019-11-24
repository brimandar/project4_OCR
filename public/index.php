<?php
//ROUTER
require '../config/dev.php';//to change to pass prod <-> dev
require '../vendor/autoload.php';


$router = new \App\config\Router();
$router->run();