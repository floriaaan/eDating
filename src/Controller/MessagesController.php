<?php
namespace src\Controller;

use src\Model\Utilisateur;
use src\Model\Messages;
use src\Model\Bdd;



//FONCTIONS APPELLEES PAR LES ROUTES
class MessagesController extends AbstractController{

        public function Index()
        {
            if (isset($_SESSION['USER'])) {
                return $this->pageMessagerie();
            } else {
                header('Location:/Utilisateur/Login');
            }

        }

        public function pageMessagerie(){
            if(isset($_SESSION['USER'])) {

                $modelMsg = new Messages();

                //contact
                $campus = '';
                $AllContact = $modelMsg->afficherContact($campus);

                //les ID
                $userid = 1;
                $contactid = 2;

                //messages
                $allMsg = $modelMsg->afficherAncienMsg($userid, $contactid);

                return $this->twig->render(
                    'messages.html.twig',[
                    'AllContact' => $AllContact,
                    'allMsg'=> $allMsg
                    ]);



            } else {
                header('Location:/Error');
            }
        }


        public function AfficherMsg($msg, $contactselect){

            if($msg != ''){

            
                $user = new Utilisateur();
                $datas = $user->getUserData($mail);
                $ownId = $datas['ID_UTILISATEUR'];
                $ownChat = new Messages();
            
                //avoir l'id du correspondant
                $idArrayOtherUser = $ownChat->getIdOtherUser($userPseudo, $ownId);
                $otherId = $idArrayOtherUser['T_U_ID_UTI'];


                $ownChat->sendMsgToMatch($ownId, $otherId, $msg);
            
                echo '<div class="d-flex justify-content-end mb-4"><div class="msg_cotainer_send">'.$msg.'</div><div class="img_cont_msg"><img src="doc/img/photo.jpg" class="rounded-circle user_img_msg"></div></div>';
        
                

            }
        }



    public function effacerMessages(){
     
        $mail = $_SESSION['email'];
        $otherId = 2;
        $user = new Utilisateur();
        $datas = $user->getUserData($mail);
        $ownId = $datas['ID_UTILISATEUR'];

        $ownChat = new Messages();
        $ownChat->effacerMessages($ownId, $otherId, $otherId, $ownId);

        $redirectprofil = "/chat";
        header("Location: " . $redirectprofil );

    }
}