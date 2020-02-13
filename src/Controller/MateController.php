<?php


namespace src\Controller;


use src\Model\Affinites;
use src\Model\Avertissement;
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

            if($user->getEmail() == $_SESSION['USER']->getEmail()) {
                header('Location:/Utilisateur/Profile');
            }

            return $this->twig->render('Mates/mate.html.twig', [
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

    public function ListMates()
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
                    'Mates/listmates.html.twig', [
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

    public function ReportForm($id){

        if (isset($_SESSION['USER'])) {
            $warnUser = (new Utilisateur)->SqlGet(Bdd::GetInstance(), $id);
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $this->twig->render(
                'Mates/report.html.twig', [
                    'warnUser' => $warnUser,
                    'token' => $token
                ]
            );

        } else {
            header('Location:/Error/NoUser');
        }
    }

    public function ReportPost(){
        if (isset($_SESSION['USER']) && $_POST && $_POST['crsf'] == $_SESSION['token']) {

            $warn = new Avertissement();
            $warn->setDate((new \DateTime)->format('Y-m-d H:m:s'))
                ->setType(htmlspecialchars($_POST['wType']))
                ->setContenu(htmlspecialchars($_POST['wContenu']));
            $warn->SqlAdd(Bdd::GetInstance(), $_POST['wUID'], $_SESSION['USER']->getUID());

            header('Location:/');

        } else {
            header('Location:/Error/NoUser');
        }
    }
}