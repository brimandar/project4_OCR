<?php
//ROUTER
require '../config/dev.php';//change to pass prod <-> dev
require '../vendor/autoload.php';

session_start();

  $router = new \App\config\Router();
  $router->run();



?>