<?php

namespace src\Controller;

use src\Model\Utilisateur;
use src\Model\Messages;
use src\Model\Bdd;


//FONCTIONS APPELLEES PAR LES ROUTES
class MessagesController extends AbstractController
{

    public function Index()
    {
        if (isset($_SESSION['USER'])) {
            return $this->ListUser();

        } else {
            header('Location:/Utilisateur/Login');
        }

    }

    public function ListUser()
    {
        if (isset($_SESSION['USER'])) {

            //contact
            $campus = $_SESSION['USER']->getCampus();
            $AllContact = (new Messages)->afficherContact($campus);
            //$AllLastMsg = ();

            return $this->twig->render(
                'Messages/listuser.html.twig', [
                'allContact' => $AllContact,
                //'allLastMsg' => $allLastMsg
            ]);


        } else {
            header('Location:/Error');
        }
    }

    public function contactForm($id)
    {
        if (isset($_SESSION['USER'])) {
            //messages
            $modelMsg = new Messages();
            $allMsg = $modelMsg->afficherAncienMsg($_SESSION['USER']->getUID(), $id);
            $user = (new Utilisateur)->SqlGet(Bdd::GetInstance(), $id);

            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $this->twig->render(
                'Messages/messages.html.twig', [
                'allMsg' => $allMsg,
                'user' => $user,
                'token' => $token
            ]);
        } else {
            header('Location:/Error');
        }


    }


    public function EnvoyerMsg()
    {

        if ($_POST && $_POST['crsf'] == $_SESSION['token']) {
            $userid = $_SESSION['USER']->getUID();
            $contactid = $_POST['sendToUser'];

            $message = (new Messages)->envoyerMsg($userid, $contactid, $_POST['msg']);
        }


        header('Location:/Messages/Contact/' . $_POST['sendToUser']);


    }
}