<?php


namespace src\Controller;


class AdminController extends AbstractController
{

    public function Test(){
        var_dump($_SESSION);
        var_dump($_SESSION['USER']->getPermission());
    }

}