<?php


namespace src\Controller;


use src\Model\Bdd;
use src\Model\Utilisateur;

class AdminController extends AbstractController
{

    public function Test(){
        self::roleNeed();
        var_dump($_SESSION['USER']->getPermission());
    }

    public function Panel(){
        self::roleNeed();
        $listUser = (new Utilisateur)->SqlGetAll(Bdd::GetInstance());
        return $this->twig->render('Admin/panel.html.twig', [
            'listUser' => $listUser
        ]);
    }

    /**
     * Verify that USER.Roles in SESSION is "Admin"
     */
    public static function roleNeed()
    {
        if (isset($_SESSION['USER'])) {
            $perm = $_SESSION['USER']->getPermission();
            $admin = false;
            foreach ($perm as $p) {
                if($p->getType() == "admin" && $p->getActive() == 1){
                    $admin = true;
                }
            }
            if (!$admin) {
                header('Location:/');
            }
        } else {
            header('Location:/Utilisateur/Login');
        }
    }

}