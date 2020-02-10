<?php


namespace src\Controller;


class ErrorController extends AbstractController
{
    public function Index() {
        return $this->twig->render(
            'Error/error.html.twig'
        );
    }

    public function BadLogin() {
        return $this->twig->render(
            'Error/badlogin.html.twig'
        );
    }

    public function NoUser() {
        return $this->twig->render(
            'Error/nouser.html.twig'
        );
    }

    public function NoToken() {
        return $this->twig->render(
            'Error/notoken.html.twig'
        );
    }

}