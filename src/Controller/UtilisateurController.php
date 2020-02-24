<?php


namespace src\Controller;

use src\Model\Affinites;
use src\Model\Like;
use src\Model\Photos;
use src\Model\Utilisateur;
use src\Model\Bdd;
use DateTime;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;


class UtilisateurController extends AbstractController
{
    /**
     * @return string
     * Redirige vers son propre profile
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function Index()
    {
        if (isset($_SESSION['USER'])) {
            return $this->Me();
        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Affiche la vue twig correspondant à la vue du profil
     */
    public function Me()
    {
        if (isset($_SESSION['USER'])) {
            return $this->twig->render(
                'Utilisateur/profile.html.twig', [
                    'affinites' => (new Affinites)->SqlGetAll(Bdd::GetInstance(), $_SESSION['USER']->getUID())
                ]

            );
        } else {
            header('Location:/Error/NoUser');
        }

    }

    /*
     * Vue alternative
     */
    public function MeAlt()
    {
        if (isset($_SESSION['USER'])) {
            return $this->twig->render(
                'Utilisateur/profile-alt.html.twig', [
                    'affinites' => (new Affinites)->SqlGetAll(Bdd::GetInstance(), $_SESSION['USER']->getUID())
                ]
            );
        } else {
            header('Location:/Error/NoUser');
        }

    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Affiche et traite l'inscription (POST && GET)
     */
    public function Register()
    {
        if ($_POST) {
            if ($_POST['tokenCRSF'] == $_SESSION['token']) {
                $dateNow = new DateTime();


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


                $sqlRepository = null;
                $nomImage = null;
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
                    foreach ($listAffinites as $aff) {
                        $affinites = new Affinites();
                        $affinites->setAffinites($aff);
                        $affinites->SqlAdd(Bdd::GetInstance(), $returnAdd['message']);
                    }


                    $user->setAffinites((new Affinites)->SqlGetAll(Bdd::GetInstance(), $returnAdd['message']));
                    $_SESSION['USER'] = $user;
                    header('Location:/Utilisateur/Profile');
                } else {
                    header('Location:/Error/');
                }
            } else {
                header('Location:/Error/NoToken');
            }


        } else {
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $this->twig->render('Utilisateur/confidentials/register.html.twig', [
                'token' => $token
            ]);
        }
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Affiche et traite la connexion (POST && GET)
     */
    public function Login()
    {

        if ($_POST) {
            if ($_POST['tokenCRSF'] == $_SESSION['token']) {
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
                header('Location:/Error/NoToken');
            }

        } else {

            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $this->twig->render('Utilisateur/confidentials/login.html.twig',
                [
                    'token' => $token
                ]);
        }
    }

    /**
     * Unset SESSION User
     */
    public function Disconnect()
    {
        session_unset();
        header('Location:/Utilisateur/Login');
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Affiche et traite la réinitialisation de mot de passe (GET && POST)
     */
    public function ForgotPass()
    {

        if ($_POST) {
            if ($_POST['tokenCRSF'] == $_SESSION['token']) {
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
                    ->setBody(
                        $this->twig->render(
                            'Utilisateur/confidentials/mail.html.twig',
                            ['token' => $passwd]), 'text/html'
                    );


                $mailer->send($message);
                //file_put_contents('../md5_pass.txt', 'http://www.edating.local/Utilisateur/ChangePassword/' . $passwd);
                $user->SqlResetPass(Bdd::GetInstance(), $_POST['forgotEmail'], $passwd);

                return $this->twig->render('Utilisateur/confidentials/forgotsend.html.twig');
            } else {
                header('Location:/Error/NoToken');
            }

        } else {
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $this->twig->render('Utilisateur/confidentials/forgot.html.twig', [
                'token' => $token
            ]);
        }
    }

    /**
     * @param string $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Change le mot de passe dans la bdd
     */
    public function ChangePassword($id = '')
    {
        $user = new Utilisateur();
        $userEmail = $user->SqlGetEmailFromToken(Bdd::GetInstance(), $id);
        if ($_POST) {

            $user->SqlResetPassFromMail(Bdd::GetInstance(), $_POST['changeEmail'], $_POST['changePass'], $_POST['changeToken']);
            header('Location:/');


        } else {
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            if ($id == '' && isset($_SESSION['USER'])) {
                //Depuis le profil

            } elseif ($id != '') {

                //Depuis le mail
                if ($userEmail != null) {
                    return $this->twig->render('Utilisateur/confidentials/changepassword.html.twig', [
                        'userEmail' => $userEmail,
                        'token' => $id,
                        'crsf' => $token
                    ]);
                }
            }
            header('Location:/Error/NoToken');

        }

    }

    /**
     * @return string|void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * Affiche la vue Twig de la modification de profil
     */
    public function ModifyGet()
    {
        if (isset($_SESSION['USER'])) {
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $this->twig->render('Utilisateur/modify.html.twig', [
                'token' => $token
            ]);
        } else {
            header('Location:/Utilisateur/Login');
        }
        return;
    }

    /**
     * Modifie le profil
     */
    public function ModifyPost()
    {
        if (isset($_SESSION['USER'])) {
            if ($_POST && $_POST['crsf'] == $_SESSION['token']) {
                $modifUser = (new Utilisateur)->SqlGet(Bdd::GetInstance(), $_SESSION['USER']->getUID());
                if (isset($_POST['mTitre'])) {
                    $modifUser = $modifUser->setTitre($_POST['mTitre']);
                }
                if (isset($_POST['mDescription'])) {
                    $modifUser = $modifUser->setDescription($_POST['mDescription']);
                }
                if (isset($_POST['mVille'])) {
                    $modifUser = $modifUser->setVille($_POST['mVille']);
                }
                if (isset($_POST['mCampus'])) {
                    $modifUser = $modifUser->setCampus($_POST['mCampus']);
                }
                if (isset($_POST['mSituaton'])) {
                    $modifUser = $modifUser->setSituation($_POST['mSituation']);
                }
                if (isset($_POST['mAge'])) {
                    $modifUser = $modifUser->setAge($_POST['mAge']);
                }
                if (isset($_POST['mAttirance'])) {
                    $modifUser = $modifUser->setAttirance($_POST['mAttirance']);
                }
                if (isset($_POST['mLong'])) {
                    $modifUser = $modifUser->setLongitude($_POST['mLong']);
                }
                if (isset($_POST['mLat'])) {
                    $modifUser = $modifUser->setLatitude($_POST['mLat']);
                }
                if (isset($_FILES['mProfilImg']['name']) && $_FILES['mProfilImg']['name'] != '') {
                    $sqlRepository = null;
                    $nomImage = null;
                    if (!empty($_FILES['mProfilImg']['name'])) {
                        $tabExt = array('jpg', 'gif', 'png', 'jpeg');    // Extensions autorisees
                        $extension = pathinfo($_FILES['mProfilImg']['name'], PATHINFO_EXTENSION);
                        if (in_array(strtolower($extension), $tabExt)) {
                            $nomImage = md5(uniqid()) . '.' . $extension;

                            $sqlRepository = $_SESSION['USER']->getEmail();
                            $repository = './uploads/images/' . $_SESSION['USER']->getEmail();
                            if (!is_dir($repository)) {
                                mkdir($repository, 0777, true);
                            }
                            move_uploaded_file($_FILES['mProfilImg']['tmp_name'], $repository . '/' . $nomImage);
                        }
                    }
                    $modifUser->setProfilImgName($nomImage);
                    $modifUser->setProfilImgRepo($sqlRepository);
                }

                if (isset($_FILES['mAddPhoto']['name']) && $_FILES['mAddPhoto']['name'] != '') {
                    $sqlRepository = null;
                    $nomImage = null;
                    if (!empty($_FILES['mAddPhoto']['name'])) {
                        $tabExt = array('jpg', 'gif', 'png', 'jpeg');    // Extensions autorisees
                        $extension = pathinfo($_FILES['mAddPhoto']['name'], PATHINFO_EXTENSION);
                        if (in_array(strtolower($extension), $tabExt)) {
                            $nomImage = md5(uniqid()) . '.' . $extension;

                            $sqlRepository = $_SESSION['USER']->getEmail();
                            $repository = './uploads/images/' . $_SESSION['USER']->getEmail();
                            if (!is_dir($repository)) {
                                mkdir($repository, 0777, true);
                            }
                            move_uploaded_file($_FILES['mAddPhoto']['tmp_name'], $repository . '/' . $nomImage);
                        }
                    }
                    $photo = new Photos();
                    $photo->setPhotoName($nomImage);
                    $photo->setPhotoDossier($sqlRepository);
                    $photo->SqlAdd(Bdd::GetInstance(), $modifUser->getUID());
                    $modifUser->setPhotos((new Photos)->SqlGetAll(Bdd::GetInstance(), $modifUser->getUID()));
                }
                if (isset($_POST['mAffinites'])) {
                    (new Affinites)->SqlDeleteAllFromUser(Bdd::GetInstance(), $modifUser->getUID());
                    $listAffinites = explode(',', $_POST['mAffinites']);


                    foreach ($listAffinites as $aff) {
                        $affinites = new Affinites();
                        $affinites->setAffinites($aff);
                        $affinites->SqlAdd(Bdd::GetInstance(), $modifUser->getUID());
                    }
                    $modifUser->setAffinites((new Affinites)->SqlGetAll(Bdd::GetInstance(), $modifUser->getUID()));
                }


                $modifUser->SqlUpdate(Bdd::GetInstance());

                $_SESSION['USER'] = $modifUser;
            }


            /*if(!empty($_FILES['mImages'])){
                foreach($_FILES['mImages'] as $image){
                    $sqlRepository = null;
                    $nomImage = null;
                    if (!empty($_FILES['mImages']['name'])) {
                        $tabExt = array('jpg', 'gif', 'png', 'jpeg');    // Extensions autorisees
                        $extension = pathinfo($_FILES['mImages']['name'], PATHINFO_EXTENSION);
                        if (in_array(strtolower($extension), $tabExt)) {
                            $nomImage = md5(uniqid()) . '.' . $extension;

                            $sqlRepository = $_POST['registerEmail'];
                            $repository = './uploads/images/' . $_POST['registerEmail'];
                            if (!is_dir($repository)) {
                                mkdir($repository, 0777, true);
                            }
                            move_uploaded_file($_FILES['mImages']['tmp_name'], $repository . '/' . $nomImage);
                        }
                    }
                    $modifUser->setProfilImgName($nomImage);
                    $modifUser->setProfilImgRepo($sqlRepository);

                }
            }*/


            header('Location:/Utilisateur/Profile');
        } else {
            header('Location:/Utilisateur/Login');
        }
        return;


    }


}