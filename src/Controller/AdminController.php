<?php


namespace src\Controller;


use src\Model\Avertissement;
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

    public function Report($id) {
        self::roleNeed();
        $allRep = (new Avertissement)->SqlGetWarnedUser(Bdd::GetInstance(), $id);
        $listRep = [];
        foreach ($allRep as $rep){
            $listRep[] = ['user' => (new Utilisateur)->SqlGet(Bdd::GetInstance(), $rep->getTransmitterUID()), 'r' => $rep];
        }


        $user = (new Utilisateur)->SqlGet(Bdd::GetInstance(), $id);
        return $this->twig->render('Admin/report.html.twig', [
            'listReports' => $listRep,
            'user' => $user
        ]);
    }

    public function ReportDelete($id) {
        self::roleNeed();
        $rep = (new Avertissement)->SqlDelete(Bdd::GetInstance(), $id);
        header('Location:/Admin/');
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
            header('Location:/Error/NoUser');
        }
    }

}