<?php


namespace src\Controller;


use src\Model\Affinites;
use src\Model\Bdd;
use src\Model\Like;
use src\Model\Utilisateur;

class HomeController extends AbstractController
{
    public function Index()
    {
        if (isset($_SESSION['USER'])) {
            return $this->Map();
        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    public function Map()
    {
        if (isset($_SESSION['USER'])) {
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

    public function Search()
    {
        if (isset($_SESSION['USER'])) {
            $user = new Utilisateur();
            if ($_POST['search'] == "*" || $_POST['search'] == "Tous") {
                $_POST['search'] = "Tout le monde";
                $listUser = $user->SqlGetAll(Bdd::GetInstance());
            } else {
                if ($_POST['origin'] == "affinites") {
                    $listUser = $user->SqlGetLike(Bdd::GetInstance(), "SELECT * FROM UTILISATEUR INNER JOIN AFFINITE
                        WHERE AFFINITE.AFF_AFFINITE  LIKE :param AND AFFINITE.ID_UTILISATEUR=UTILISATEUR.ID_UTILISATEUR",
                        $_POST['search']);
                } else {
                    $listUser = $user->SqlGetLike(Bdd::GetInstance(), "SELECT * FROM UTILISATEUR
                        WHERE UTI_NOM LIKE :param OR UTI_PRENOM LIKE :param OR UTILISATEUR.ID_UTILISATEUR LIKE :param
                            OR UTI_SEXE LIKE :param OR UTI_ATTIRANCE LIKE :param OR UTI_CAMPUS LIKE :param",
                        $_POST['search']);
                    $listUser += $user->SqlGetLike(Bdd::GetInstance(), "SELECT * FROM UTILISATEUR INNER JOIN AFFINITE
                        WHERE AFFINITE.AFF_AFFINITE LIKE :param AND AFFINITE.ID_UTILISATEUR=UTILISATEUR.ID_UTILISATEUR",
                        $_POST['search']);
                }
            }


            if ($listUser != null && $_POST['origin'] == "index") {
                return $this->twig->render(
                    'search.html.twig', [
                        'listUser' => $listUser,
                        'search' => $_POST['search']

                    ]
                );
            } elseif ($listUser != null && $_POST['origin'] == "affinites") {
                return $this->twig->render(
                    'affsearch.html.twig', [
                        'listUser' => $listUser,
                        'search' => $_POST['search']

                    ]
                );
            } elseif ($listUser == null && $_POST['origin'] == "affinites") {
                return $this->twig->render(
                    'Error/affsearchempty.html.twig', [
                        'search' => $_POST['search']
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


}