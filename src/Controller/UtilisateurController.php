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
            'Map.html.twig', [
                'userList' => $listUser
        ]);
    }
}