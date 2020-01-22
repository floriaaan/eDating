<?php


namespace src\Controller;


class ErrorController extends AbstractController
{
    public function Index(){
        return $this->twig->render(
            '404.html.twig'
        );
    }
}