<?php


namespace src\Controller;

use src\Model\Utilisateur;
use src\Model\Bdd;
use DateTime;

class UtilisateurController extends AbstractController
{
    public function Index(){
        if(isset($_SESSION['USER'])) {
            return $this->Map();
        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    public function Map(){
        $user = new Utilisateur();
        $listUser = $user->SqlGetAll(Bdd::GetInstance());
        return $this->twig->render(
            'map.html.twig', [
                'userList' => $listUser
        ]);
    }

    public function Search(){
        $user = new Utilisateur();
        $listUser = $user->SqlGetBy(Bdd::GetInstance(),"SELECT * FROM T_UTILISATEUR WHERE UTI_NOM =:Search OR UTI_PRENOM =:Search OR ID_UTILISATEUR =:Search", $_POST['search']);

        return $this->twig->render(
            'search.html.twig', [
                'listUser' => $listUser,
            ]
        );
    }

    public function Me(){
        if(isset($_SESSION['USER'])) {
            return $this->twig->render(
                'Utilisateur/profile.html.twig'

            );
        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    public function Register(){
        if($_POST){
            $dateNow = new DateTime();
            $sqlRepository = null;
            $nomImage = null;

            $user = new Utilisateur();
            $user->setMotDePasse(password_hash($_POST['registerMotDePasse'], PASSWORD_BCRYPT))
                ->setNom($_POST['registerNom'])
                ->setPrenom($_POST['registerPrenom'])
                ->setDateInscription($dateNow->format('Y-m-d'))
                ->setEmail($_POST['registerEmail'])
                ->setTitre($_POST['registerTitre'])
                ->setDescription($_POST['registerDescription'])
                ->setSexe($_POST['registerSexe'])
                ->setVille($_POST['registerVille'])
                ->setTelephone($_POST['registerNom'])
                ->setCampus($_POST['registerCampus'])
                ->setSituation($_POST['registerSituation'])
                ->setAge($_POST['registerAge'])
                ->setAttirance($_POST['registerAttirance'])
                ->setLatitude(mt_rand(-90, 90))
                ->setLongitude(mt_rand(-180, 180));

            ;
            /*if(!empty($_FILES['registerImage']['name']) )
            {
                $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
                $extension  = pathinfo($_FILES['registerImage']['name'], PATHINFO_EXTENSION);
                if(in_array(strtolower($extension),$tabExt))
                {
                    $nomImage = md5(uniqid()) .'.'. $extension;

                    $sqlRepository = $dateNow->format('Y/m');
                    $repository = './uploads/images/'.$_POST['registerEmail'];
                    if(!is_dir($repository)){
                        mkdir($repository,0777,true);
                    }
                    move_uploaded_file($_FILES['registerImage']['tmp_name'], $repository.'/'.$nomImage);
                }
            }
            $user->setImgFileName($nomImage);
            $user->setImgRepo($sqlRepository);*/
            if($user->SqlAdd(BDD::getInstance())['result']) {
                $_SESSION['USER'] = $user;
                header('Location:/Utilisateur/Me');
            } else {
                header('Location:/Error/');
            }

        }else{

            return $this->twig->render('Utilisateur/register.html.twig');
        }
    }

    public function Login(){

        if($_POST) {
            $bdd = Bdd::GetInstance();
            $password = $_POST['loginPassword'];

            $requete = $bdd->prepare("SELECT ID_UTILISATEUR, UTI_MDP FROM T_UTILISATEUR WHERE UTI_EMAIL =:Email");
            $requete->execute([
                'Email' => $_POST['loginEmail']]);
            $returnSQL = $requete->fetch();


            if(password_verify($password, $returnSQL['UTI_MDP'])) {


                $user = new Utilisateur();
                $user = $user->SqlGet($bdd, $returnSQL['ID_UTILISATEUR']);
                $_SESSION['USER'] = $user;
                header('Location:/');

            } else {
                $_SESSION['connected'] = false;
                $_SESSION['USER'] = null;
                header('Location:/Error/BadLogin');
            }
        } else {

            return $this->twig->render('Utilisateur/login.html.twig');
        }
    }

    public function Disconnect(){
        session_unset();
        header('Location:/Utilisateur/Login');
    }


}