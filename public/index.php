<?php

include "config.php";
require '../vendor/autoload.php';


//http://www.git.local/?controller=Article&action=Add

$controller = (!empty($_GET['controller']) ? $_GET['controller'] : 'Utilisateur');
$action = (!empty($_GET['action']) ? $_GET['action'] : 'Index');
$param = (!empty($_GET['id']) ? $_GET['id'] : '');

$className = 'src\Controller\\' . $controller . 'Controller';
if (class_exists($className)) {
    $classController = new $className;
    if (method_exists($className, $action)) {
        echo $classController->$action($param);
    } else {
        var_dump($_POST);
        echo 'L\'action ' . $action . ' n\'existe pas';
    }
} else {
    echo 'Pas de controller pour cette page';
    var_dump($className);
}


