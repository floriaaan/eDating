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

    // Affichage de la liste de contact
    public function ListUser()
    {
        if (isset($_SESSION['USER'])) {

            //contact
            $campus = $_SESSION['USER']->getCampus();
            $AllContact = (new Utilisateur)->SqlGetBy(Bdd::GetInstance(), 'SELECT * FROM UTILISATEUR
                WHERE UTI_CAMPUS=:param', $campus);


            $Conversations = [];
            foreach ($AllContact as $contact) {
                $message = (new Messages)->getLastMsg(Bdd::GetInstance(), $contact->getUID(), $_SESSION['USER']->getUID());

                $Conversations[] = [
                    'contact' => $contact,
                    'messageContent' => $message['MES_CONTENU'],
                    'messageDate' => $message['MES_DATE']
                ];
            }
            return $this->twig->render(
                'Messages/listuser.html.twig', [
                'conversations' => $Conversations
            ]);


        } else {
            header('Location:/Error');
        }
    }

    // Affichage de tous les messages par utilisateur
    public function contactForm($id)
    {
        if (isset($_SESSION['USER'])) {
            //messages
            $modelMsg = new Messages();
            $allMsg = $modelMsg->afficherAncienMsg($_SESSION['USER']->getUID(), $id);
            $user = (new Utilisateur)->SqlGet(Bdd::GetInstance(), $id);

            (new Messages)->SqlSetToReadMsg(Bdd::GetInstance(), $id, $_SESSION['USER']->getUID());

            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $this->twig->render(
                'Messages/messages.html.twig', [
                'allMsg' => $allMsg,
                'user' => $user,
                'token' => $token,
                'stoken' => $_SESSION['token']
            ]);
        } else {
            header('Location:/Error');
        }


    }

    // Envoyer un messages non vide
    public function EnvoyerMsg()
    {
        if ($_POST) {
            $userid = $_SESSION['USER']->getUID();
            $contactid = $_POST['sendToUser'];

            $message = (new Messages)->envoyerMsg($userid, $contactid, $_POST['msg']);
        }


        header('Location:/Messages/Contact/' . $_POST['sendToUser']);


    }
}