<?php

use src\Model\Utilisateur;

include "config.php";

if(isset($_POST)){
    if($_POST['origin'] == "login") {
        $password = $_POST['loginPassword'];

        $requete = $bdd->prepare("SELECT ID_UTILISATEUR, UTI_MDP FROM T_UTILISATEUR WHERE UTI_EMAIL =:Email");
        $requete->execute([
            'Email' => $_POST['loginEmail']]);
        $returnSQL = $requete->fetch();


        if(password_verify($password, $returnSQL['UTI_MDP'])) {
            $_SESSION['connected'] = true;

            $requete = $bdd->prepare("UPDATE T_UTILISATEUR SET UTI_CONNECTE=1 WHERE UTI_EMAIL =:Email");
            $requete->execute([
                'Email' => $_POST['loginEmail']]);


            $user = new Utilisateur();
            $user = $user->SqlGet($bdd, $returnSQL['ID_UTILISATEUR']);
            $_SESSION['USER'] = $user;
            header('Location:/Utilisateur/Me');

        } else {
            $_SESSION['connected'] = false;
            $_SESSION['USER'] = null;
            header('Location:/Error');
        }
    } elseif ($_POST['origin'] == "register") {
        var_dump($_POST);

    } else {
        header('Location:/Error');
    }



}

