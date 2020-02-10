<?php



function chargerClasse($classe)
{
    $ds = DIRECTORY_SEPARATOR;
    $dir = __DIR__ . "{$ds}.."; //Remonte d'un cran par rapport à index.html.twig
    $classeName = str_replace('\\', $ds, $classe);

    $file = "{$dir}{$ds}{$classeName}.php";
    if (is_readable($file)) {
        require_once $file;
    }
}

spl_autoload_register('chargerClasse');

session_start();

/*$hostname="mysql-floriaaan.alwaysdata.net";
$username="floriaaan_fym";
$password=file_get_contents('../db_pw.txt');
$dbname="floriaaan_fym";*/

