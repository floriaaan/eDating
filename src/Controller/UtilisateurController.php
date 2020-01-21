<?php


namespace src\Controller;

use src\Model\Utilisateur;
use src\Model\Bdd;
use DateTime;

class UtilisateurController extends AbstractController
{
    public function Index(){
        return $this->Map();
    }

    public function Map(){
        $user = new Utilisateur();
        $listUser = $user->SqlGetAll(Bdd::GetInstance());
        return $this->twig->render(
            'map.html.twig', [
                'userList' => $listUser
        ]);
    }

    public function Mate(){
        $user = new Utilisateur();
        return $this->twig->render(
            'mate.html.twig', [
                'user' => $user->SqlGet(Bdd::GetInstance(), $_POST['search']),
                'post' => $_POST
            ]
        );
    }

    public function Me(){
        $user = new Utilisateur();
        return $this->twig->render(
            'profile.html.twig', [
                'user' => $user->SqlGet(Bdd::GetInstance(), $_SESSION['id']),
            ]
        );
    }


}