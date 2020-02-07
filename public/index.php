<?php

include "config.php";
require '../vendor/autoload.php';


$router = new \src\Router\Router($_GET['url']);

//Home Routes
$router->get('/', "Home#Index");
$router->get('/Home/', "Home#Index");
$router->get('/Home/Map', "Home#Map");
$router->post('/Home/Search', "Home#Search");
$router->get('/Home/Mate/:id', "Home#Mate#id");

//Error Routes
$router->get('/Error/', 'Error#Index');
$router->get('/Error/BadLogin', 'Error#BadLogin');
$router->get('/Error/NoUser', 'Error#NoUser');
$router->get('/Error/NoToken', 'Error#NoToken');

//Utilisateur Routes

$router->get('/Utilisateur/', 'Utilisateur#Index');
$router->get('/Utilisateur/Me', 'Utilisateur#Me');
$router->get('/Utilisateur/Register', 'Utilisateur#Register');
$router->post('/Utilisateur/Register', 'Utilisateur#Register');
$router->get('/Utilisateur/Login', 'Utilisateur#Login');
$router->post('/Utilisateur/Login', 'Utilisateur#Login');
$router->get('/Utilisateur/Disconnect', 'Utilisateur#Disconnect');
$router->get('/Utilisateur/ForgotPass', 'Utilisateur#ForgotPass');
$router->post('/Utilisateur/ForgotPass', 'Utilisateur#ForgotPass');
$router->get('/Utilisateur/ChangePassword/:id', 'Utilisateur#ChangePassword#id');
$router->post('/Utilisateur/ChangePassword/', 'Utilisateur#ChangePassword');
$router->get('/Utilisateur/Like/:id', 'Utilisateur#Like#id');
$router->get('/Utilisateur/Mates/', 'Utilisateur#Mates');


echo $router->run();