<?php


namespace src\Controller;


use src\Model\Affinites;
use src\Model\Bdd;
use src\Model\Like;
use src\Model\Utilisateur;

class MateController extends AbstractController
{

    public function Mate($id)
    {
        if (isset($_SESSION['USER'])) {
            $user = new Utilisateur();
            $user = $user->SqlGet(Bdd::GetInstance(), $id);
            return $this->twig->render('mate.html.twig', [
                    'user' => $user,
                    'affinites' => (new Affinites)->SqlGetAll(Bdd::GetInstance(), $id),
                ]
            );

        } else {
            header('Location:/Error/NoUser');
        }
    }

    public function Like($id)
    {
        if (isset($_SESSION['USER'])) {
            $listLikes = (new Like())->SqlGetAll(Bdd::GetInstance(), $_SESSION['USER']->getUID());
            if (!in_array($id, $listLikes)) {
                $L = new Like();
                $L->setUserLiked($id);
                $L->SqlAdd(Bdd::GetInstance(), $_SESSION['USER']->getUID());
                header("location:/Mate/List");
            } else {
                $L = new Like();
                $L->SqlDelete(Bdd::GetInstance(), $_SESSION['USER']->getUID(), $id);
                header("location:/Mate/List");
            }
        } else {
            header('Location:/Utilisateur/Login');
        }
    }

    public function Mates()
    {
        if (isset($_SESSION['USER'])) {
            $_SESSION['USER'] = (new Utilisateur)->SqlGet(Bdd::GetInstance(), $_SESSION['USER']->getUID());
            $listLikedByMe = $_SESSION['USER']->getLikes();
            $listLikedMe = (new Like)->SqlGetLikedMe(Bdd::GetInstance(), $_SESSION['USER']->getUID());

            $user = new Utilisateur();
            $listUser = [];

            if($listLikedByMe != null) {
                foreach($listLikedByMe as $userInList) {
                    $listUser[] = $user->SqlGet(Bdd::GetInstance(), $userInList);
                }
            }

            if ($listLikedMe != null){
                foreach($listLikedMe as $userInList) {
                    $listUser[] = $user->SqlGet(Bdd::GetInstance(), $userInList);
                }
            }


            if ($listUser != null) {
                return $this->twig->render(
                    'search.html.twig', [
                        'listUser' => $listUser,

                    ]
                );
            } else {
                return $this->twig->render(
                    'Error/nolikes.html.twig'

                );
            }
        } else {
            header('Location:/Error/NoUser');
        }
    }
}