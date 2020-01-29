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
            if($_POST['search'] == "*" || $_POST['search'] == "Tous") {
                $listUser = $user->SqlGetAll(Bdd::GetInstance());
            } else {
                $listUser = $user->SqlGetBy(Bdd::GetInstance(),"SELECT * FROM T_UTILISATEUR 
                WHERE UTI_NOM =:param OR UTI_PRENOM =:param OR ID_UTILISATEUR =:param
                   OR UTI_SEXE =:param OR UTI_ATTIRANCE=:param OR UTI_CAMPUS=:param", $_POST['search']);
            }


            if ($listUser != null) {
                return $this->twig->render(
                    'search.html.twig', [
                        'listUser' => $listUser,
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

    public function Mate($id){
        if(isset($_SESSION['USER'])) {
            $user = new Utilisateur();
            $user = $user ->SqlGet(Bdd::GetInstance(), $id);
            return $this->twig->render('mate.html.twig', [
                    'user' => $user
                ]
            );

        } else {
            header('Location:/Error/NoUser');
        }
    }


}