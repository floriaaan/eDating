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
                'userList' => $listUser,
                'session' => $_SESSION
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
        if(isset($_SESSION['USER'])) {
            return $this->twig->render(
                'profile.html.twig', [
                    'user' => $_SESSION['USER'],
                    'session' => $_SESSION
                ]
            );
        } else {
            header('Location:/Error');
        }

    }

    public function Add(){
        if(isset($_POST)){
            $dateNow = new DateTime();
            $sqlRepository = null;
            $nomImage = null;

            $user = new Utilisateur();
            $user->setNom($_POST['registerNom'])
                ->setPrenom($_POST['registerPrenom'])
                ->setDateInscription($dateNow->format('Y-m-d'))
                ->setEmail($_POST['registerEmail'])
                ->setTitre($_POST['registerTitre'])
                ->setDescription($_POST['registerDescription'])
                ->setSexe($_POST['registerSexe'])
                ->setTravail($_POST['registerTravail'])
                ->setEstConnecte(1)
                ->setTelephone($_POST['registerTelephone'])
                ->setLatitude($_POST['registerLat'])
                ->setLongitude($_POST['registerLong'])
                ->setMotDePasse(password_hash($_POST['registerMotDePasse'], PASSWORD_BCRYPT))
            ;
            /*if(!empty($_FILES['registerImage']['name']) )
            {
                $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
                $extension  = pathinfo($_FILES['registerImage']['name'], PATHINFO_EXTENSION);
                if(in_array(strtolower($extension),$tabExt))
                {
                    $nomImage = md5(uniqid()) .'.'. $extension;

                    $sqlRepository = $dateNow->format('Y/m');
                    $repository = './uploads/images/'.$dateNow->format('Y/m');
                    if(!is_dir($repository)){
                        mkdir($repository,0777,true);
                    }
                    move_uploaded_file($_FILES['registerImage']['tmp_name'], $repository.'/'.$nomImage);
                }
            }
            $user->setImgFileName($nomImage);
            $user->setImgRepo($sqlRepository);*/
            $user->SqlAdd(BDD::getInstance());
            $_SESSION['USER'] = $user;
            header('Location:/Utilisateur/Me');
        }else{
            header('Location:/Error/');
        }
    }


}