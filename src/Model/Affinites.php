<?php


namespace src\Model;


class Affinites
{
    private $Affinites;

    public function SqlGetAll(\PDO $bdd, $userID) {
        $query = $bdd->prepare('SELECT * FROM AFFINITE WHERE ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $userID]);
        $rSQL = $query->fetchAll();
        $listAffinites = [];
        foreach ($rSQL as $affinite) {
            $a = new Affinites();
            $a->setAffinites($affinite['AFF_AFFINITE']);

            $listAffinites[] = $a;
        }

        return $listAffinites;
    }





    /**
     * @return mixed
     */
    public function getAffinites()
    {
        return $this->Affinites;
    }

    /**
     * @param mixed $Affinites
     * @return Affinites
     */
    public function setAffinites($Affinites)
    {
        $this->Affinites = $Affinites;
        return $this;
    }


}