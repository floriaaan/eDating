<?php


namespace src\Controller;

use src\Model\Affinites;
use src\Model\Like;
use src\Model\Utilisateur;
use src\Model\Bdd;
use DateTime;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class UtilisateurController extends AbstractController
{
    public function Index()
    {
        if (isset($_SESSION['USER'])) {
            return $this->Me();
        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    public function Me()
    {
        if (isset($_SESSION['USER'])) {
            return $this->twig->render(
                'Utilisateur/profile.html.twig'

            );
        } else {
            header('Location:/Error/NoUser');
        }

    }

    public function Register()
    {
        if ($_POST) {
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
                ->setTelephone($_POST['registerTelephone'])
                ->setCampus($_POST['registerCampus'])
                ->setSituation($_POST['registerSituation'])
                ->setAge($_POST['registerAge'])
                ->setAttirance($_POST['registerAttirance'])
                ->setLatitude($_POST['registerLat'])
                ->setLongitude($_POST['registerLong']);

            if (!empty($_FILES['registerImg']['name'])) {
                $tabExt = array('jpg', 'gif', 'png', 'jpeg');    // Extensions autorisees
                $extension = pathinfo($_FILES['registerImg']['name'], PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), $tabExt)) {
                    $nomImage = md5(uniqid()) . '.' . $extension;

                    $sqlRepository = $_POST['registerEmail'];
                    $repository = './uploads/images/' . $_POST['registerEmail'];
                    if (!is_dir($repository)) {
                        mkdir($repository, 0777, true);
                    }
                    move_uploaded_file($_FILES['registerImg']['tmp_name'], $repository . '/' . $nomImage);
                }
            }
            $user->setProfilImgName($nomImage);
            $user->setProfilImgRepo($sqlRepository);


            $listAffinites = explode(',', $_POST['registerAffinites']);


            $returnAdd = $user->SqlAdd(BDD::getInstance());
            if ($returnAdd['result']) {
                foreach( $listAffinites as $aff) {
                    $affinites = new Affinites();
                    $affinites->setAffinites($aff);
                    $affinites->SqlAdd(Bdd::GetInstance(),$returnAdd['message']);
                }


                $user->setAffinites((new Affinites)->SqlGetAll(Bdd::GetInstance(), $returnAdd['message']));
                $_SESSION['USER'] = $user;
                header('Location:/Utilisateur/Me');
            } else {
                header('Location:/Error/');
            }

        } else {

            return $this->twig->render('Utilisateur/confidentials/register.html.twig');
        }
    }

    public function Login()
    {

        if ($_POST) {
            $bdd = Bdd::GetInstance();
            $password = $_POST['loginPassword'];

            $requete = $bdd->prepare("SELECT ID_UTILISATEUR, UTI_MDP FROM UTILISATEUR WHERE UTI_EMAIL =:Email");
            $requete->execute([
                'Email' => $_POST['loginEmail']]);
            $returnSQL = $requete->fetch();


            if (password_verify($password, $returnSQL['UTI_MDP'])) {


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

            return $this->twig->render('Utilisateur/confidentials/login.html.twig');
        }
    }

    public function Disconnect()
    {
        session_unset();
        header('Location:/Utilisateur/Login');
    }

    public function ForgotPass()
    {

        if ($_POST) {
            $user = new Utilisateur();


            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!_-.?';
            $passwd = '';
            for ($i = 0; $i < 24; $i++) {
                $passwd .= $chars[rand(0, strlen($chars) - 1)];
            }
            $passwd = md5($passwd);

            $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 465))
                ->setUsername('2e681f72979a38')
                ->setPassword('b36efe9206d692');


            $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message('Réinitialisation de mot de passe'))
                ->setFrom(['reinitialisation@findmymate.fr' => 'Find My Mate'])
                ->setTo([$_POST['forgotEmail']])
                ->setBody('http://www.edating.local/Utilisateur/ChangePassword/' . $passwd, 'text/plain');


            $mailer->send($message);
            //file_put_contents('../md5_pass.txt', 'http://www.edating.local/Utilisateur/ChangePassword/' . $passwd);
            $user->SqlResetPass(Bdd::GetInstance(), $_POST['forgotEmail'], $passwd);

            return $this->twig->render('Utilisateur/confidentials/forgotsend.html.twig');
        } else {
            return $this->twig->render('Utilisateur/confidentials/forgot.html.twig');
        }
    }

    public function ChangePassword($id)
    {
        $user = new Utilisateur();
        $userEmail = $user->SqlGetEmailFromToken(Bdd::GetInstance(), $id);
        if ($_GET && $_POST) {
            $user->SqlResetPassFromMail(Bdd::GetInstance(), $_POST['changeEmail'], $_POST['changePass'], $_POST['changeToken']);
            header('Location:/');
        } else {
            if ($id == '' && isset($_SESSION['USER'])) {
                //Depuis le profil

            } elseif ($id != '') {

                //Depuis le mail
                if ($userEmail != null) {
                    return $this->twig->render('Utilisateur/confidentials/changepassword.html.twig', [
                        'userEmail' => $userEmail,
                        'token' => $id
                    ]);
                }
            }
            header('Location:/Error/NoToken');

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
                header("location:/Utilisateur/Mates");
            } else {
                $L = new Like();
                $L->SqlDelete(Bdd::GetInstance(), $_SESSION['USER']->getUID(), $id);
                header("location:/Utilisateur/Mates");
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