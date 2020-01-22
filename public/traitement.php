<?php

use src\Model\Utilisateur;

include "config.php";

if(isset($_POST)){
    } elseif ($_POST['origin'] == "search") {
        $requete = $bdd->prepare("SELECT ID_UTILISATEUR FROM T_UTILISATEUR WHERE UTI_NOM =:Search OR UTI_PRENOM =:Search OR ID_UTILISATEUR =:Search");
        $requete->execute([
            'Search' => $_POST['search']]);
        $returnSQL = $requete->fetchObject();


        $listUser = [];
        foreach ($returnSQL as $id) {

            $user = new Utilisateur();
            $user = $user->SqlGet(\src\Model\Bdd::GetInstance(),$id);

            $listUser[] = $user;
        }

        $_POST['listUser'] = $listUser;
        header('Location:/Utilisateur/Search');

    } else {
        header('Location:/Error');
    }



}

