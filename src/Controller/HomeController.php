<?php


namespace src\Controller;


use src\Model\Affinites;
use src\Model\Bdd;
use src\Model\Like;
use src\Model\Utilisateur;

class HomeController extends AbstractController
{
    /**
     * @return string
     * Redirirge vers Map si on est connecté
     */
    public function Index()
    {
        if (isset($_SESSION['USER'])) {
            return $this->Map();
        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Affiche la vue Twig correspondant à la map
     */
    public function Map()
    {
        if (isset($_SESSION['USER'])) {
            $user = new Utilisateur();
            $listUser = $user->SqlGetAll(Bdd::GetInstance());
            return $this->twig->render(
                'Home/map.html.twig', [
                'userList' => $listUser
            ]);
        } else {
            header('Location:/Error/NoUser');
        }
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Moteur de recherche
     */
    public function Search()
    {
        if (isset($_SESSION['USER'])) {
            if($_POST) {
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
                        'Home/search.html.twig', [
                            'listUser' => $listUser,
                            'search' => $_POST['search']

                        ]
                    );
                } elseif ($listUser != null && $_POST['origin'] == "affinites") {
                    return $this->twig->render(
                        'Home/affsearch.html.twig', [
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
                header('Location:/Error/');
            }

        } else {
            header('Location:/Error/NoUser');
        }
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Debug purposes (Print PasswordReset Mail)
     */
    public function Mail(){
        return $this->twig->render('Utilisateur/confidentials/mail.html.twig');
    }




}