<?php

session_start();

$hostname="mysql-floriaaan.alwaysdata.net";
$username="floriaaan_fym";
$password="6Ug@G59W5WfjSci";
$dbname="floriaaan_fym";

try
{
    $bdd = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8', $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
