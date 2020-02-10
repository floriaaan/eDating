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
                $userid = $_SESSION['USER']->getUID();
                $contactid = 1;

                //messages
                $allMsg = $modelMsg->afficherAncienMsg($userid, $contactid);

                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                return $this->twig->render(
                    'messages.html.twig',[
                    'AllContact' => $AllContact,
                    'allMsg'=> $allMsg,
                    'sendToUser' => $contactid,
                    'token' => $token
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
    

    public function EnvoyerMsg(){

        if($_POST && $_POST['crsf'] == $_SESSION['token']) {
            $userid = $_SESSION['USER']->getUID();
            $contactid = $_POST['sendToUser'];
    
            $message = (new Messages)->envoyerMsg($userid, $contactid, $_POST['msg']);
        }
        

        header('Location:/Messages');



    }
}