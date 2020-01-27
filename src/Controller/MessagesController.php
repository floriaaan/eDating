<?php
namespace src\Controller;

use src\Model\Messages;
use src\Model\Bdd;

class MessagesController extends AbstractController{

    public function Index(){
        return $this->twig->render('messages.html.twig');

    }

}