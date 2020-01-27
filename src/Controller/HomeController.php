<?php


namespace src\Controller;


use src\Model\Bdd;
use src\Model\Utilisateur;

class HomeController extends AbstractController
{
    public function Index(){
        if(isset($_SESSION['USER'])) {
            return $this->Map();
        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    public function Map(){
        if(isset($_SESSION['USER'])) {
            $user = new Utilisateur();
            $listUser = $user->SqlGetAll(Bdd::GetInstance());
            return $this->twig->render(
                'map.html.twig', [
                'userList' => $listUser
            ]);
        } else {
            header('Location:/Error/NoUser');
        }
    }

    public function Search(){
        if(isset($_SESSION['USER'])) {
            $user = new Utilisateur();
            $listUser = $user->SqlGetBy(Bdd::GetInstance(),"SELECT * FROM T_UTILISATEUR WHERE UTI_NOM =:Search OR UTI_PRENOM =:Search OR ID_UTILISATEUR =:Search", $_POST['search']);

            if ($listUser['isEmpty'] == false) {
                return $this->twig->render(
                    'search.html.twig', [
                        'listUser' => $listUser['list'],
                    ]
                );
            } else {
                return $this->twig->render(
                    'Error/searchempty.html.twig', [
                        'search' => $_POST['search']
                    ]
                );
            }

        } else {
            header('Location:/Error/NoUser');
        }
    }


}