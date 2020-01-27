<?php

include "config.php";
require '../vendor/autoload.php';


//http://www.git.local/?controller=Article&action=Add

$controller = (!empty($_GET['controller']) ? $_GET['controller'] : 'Home');
$action = (!empty($_GET['action']) ? $_GET['action'] : 'Index');
$param = (!empty($_GET['id']) ? $_GET['id'] : '');

$className = 'src\Controller\\' . $controller . 'Controller';
if (class_exists($className)) {
    $classController = new $className;
    if (method_exists($className, $action)) {
        echo $classController->$action($param);
    } else {
        echo '
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                <div class="jumbotron">
                  <h1 class="display-4">Débogage</h1>
                  <p class="lead">Nous sommes désolé du dérangement, veuillez nous excuser de la gêne occasionnée...</p>
                  <hr class="my-4">
                  <p>L\'action '. $action . ' n\'existe pas</p>
                  <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/index.php" role="button">Retour à l\'accueil</a>
                  </p>
                </div>';
        var_dump($_POST);
        var_dump($_SESSION);
    }
} else {
    echo 'Pas de controller pour cette page';
    var_dump($className);
}


