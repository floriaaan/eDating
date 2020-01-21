<?php

include "config.php";

if(isset($_POST)){
    if($_POST['origin'] == "login") {
        $password = $_POST['inputPassword'];
        $password = password_hash($password, PASSWORD_BCRYPT);


        /*$requete = $bdd->prepare("SELECT UTI_MDP FROM T_UTILISATEUR WHERE UTI_EMAIL :=Email");
        $requete->execute([
            'Email' => $_POST['inputEmail']]);
        $passwordSQL = $requete->fetch();

        $password == $passwordSQL ? $_SESSION['connected'] = true : $_SESSION['connected'] = false;*/
    } elseif ($_POST['origin'] == "register") {

    }
    var_dump($_POST);
    var_dump($_POST['inputPassword']);

}
