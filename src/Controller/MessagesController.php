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
                return $this->message();
            } else {
                header('Location:/Utilisateur/Login');
            }

        }

        public function message(){
            if(isset($_SESSION['USER'])) {
                $modelMsg = new Messages();
                $campus = '';
                $AllContact = $modelMsg->afficherContact($campus);
                return $this->twig->render(
                    'messages.html.twig',[
                    'AllContact' => $AllContact

                    ]);
            } else {
                header('Location:/Error');
            }
        }


        public function AfficherNbMsg($msg, $contactselect){

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



    public function getOldMsg($userPseudo){
        session_start();
        $mail = $_SESSION['email'];

            

            $user = new Utilisateur();
            $datas = $user->getUserData($mail);
            $ownId = $datas['ID_UTI'];
            $ownChat = new GlobalMessages();

            //avoir l'id du correspondant
            $idArrayOtherUser = $ownChat->getIdOtherUser($userPseudo, $ownId);
            $otherId = $idArrayOtherUser['T_U_ID_UTI'];


            $AllrecevedAndSendMsged = $ownChat->getAllMsg($ownId, $otherId, $otherId, $ownId);

            foreach ($AllrecevedAndSendMsged as $values){
                if($values['ID_UTI'] == $ownId){
                    echo '<div class="d-flex justify-content-end mb-4"><div class="msg_cotainer_send">'.$values['CHA_TEXTE'].'</div><div class="img_cont_msg"><img src="doc/img/photo.jpg" class="rounded-circle user_img_msg"></div></div>';
                }else{
                    echo '<div class="d-flex justify-content-start mb-4"><div class="img_cont_msg"><img src="doc/img/photo.jpg" class="rounded-circle user_img_msg"></div><div class="msg_cotainer">'.$values['CHA_TEXTE'].'</div></div>';
                }
            }   
        
    }






}