<?php

include "config.php";
require '../vendor/autoload.php';


$router = new \src\Router\Router($_GET['url']);

//Home Routes
$router->get('/', "Home#Index");
$router->get('/Home/', "Home#Index");
$router->get('/Home/Map', "Home#Map");
$router->get('/Home/Search', "Error#Index"); // Error
$router->post('/Home/Search', "Home#Search");


//Error Routes
$router->get('/Error/', 'Error#Index');
$router->get('/Error/BadLogin', 'Error#BadLogin');
$router->get('/Error/NoUser', 'Error#NoUser');
$router->get('/Error/NoToken', 'Error#NoToken');

//Utilisateur Routes

$router->get('/Utilisateur/', 'Utilisateur#Index');
$router->get('/Utilisateur/Profile', 'Utilisateur#Me');
$router->get('/Utilisateur/Profile/Alt', 'Utilisateur#MeAlt');
$router->get('/Utilisateur/Profile/Settings', 'Utilisateur#Modify');

$router->get('/Utilisateur/Register', 'Utilisateur#Register');
$router->post('/Utilisateur/Register', 'Utilisateur#Register');
$router->get('/Utilisateur/Login', 'Utilisateur#Login');
$router->post('/Utilisateur/Login', 'Utilisateur#Login');
$router->get('/Utilisateur/Disconnect', 'Utilisateur#Disconnect');
$router->get('/Utilisateur/ForgotPass', 'Utilisateur#ForgotPass');
$router->post('/Utilisateur/ForgotPass', 'Utilisateur#ForgotPass');
$router->get('/Utilisateur/ChangePassword/:id', 'Utilisateur#ChangePassword#id');
$router->post('/Utilisateur/ChangePassword/', 'Utilisateur#ChangePassword');


//Mates Routes
$router->get('/Mate/', 'Mate#Mates');
$router->get('/Mate/List/', 'Mate#Mates');
$router->get('/Mate/Profile/:id', "Mate#Mate#id");
$router->get('/Mate/Like/:id', 'Mate#Like#id');

//Message Routes
$router->get('/Messages/', 'Messages#Index');
$router->get('/Messages/List', 'Messages#Index');
$router->get('/Messages/Contact/:id', 'Messages#ContactForm#id');
$router->post('/Messages', 'Messages#envoyerMsg');


echo $router->run();