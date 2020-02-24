<?php


namespace src\Model;


class Affinites
{
    private $Affinites;

    public function SqlGetAll(\PDO $bdd, $userID)
    {
        $query = $bdd->prepare('SELECT * FROM AFFINITE WHERE ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $userID]);
        $rSQL = $query->fetchAll();
        $listAffinites = [];
        foreach ($rSQL as $affinite) {

            $listAffinites[] = $affinite['AFF_AFFINITE'];
        }

        return $listAffinites;
    }



    public function SqlDelete(\PDO $bdd, $userID, $affID)
    {
        $query = $bdd->prepare('DELETE FROM AFFINITE WHERE ID_AFFINITE =:affID AND ID_UTILISATEUR =:userID');
        return $query->execute([
            'affID' => $affID,
            'userID' => $userID]);
    }

    public function SqlAdd(\PDO $bdd, $userID)
    {
        try {
            $query = $bdd->prepare('INSERT INTO AFFINITE (ID_UTILISATEUR, AFF_AFFINITE) VALUES (:userID, :aff)');
            $query->execute([
                'userID' => $userID,
                'aff' => $this->getAffinites()]);
            $return = array("result" => true, "message" => $bdd->lastInsertId());
        } catch (\Exception $e) {
            $return = array("result" => false, "message" => $e->getMessage());

        }
        return $return;
    }

    public function SqlDeleteAllFromUser(\PDO $bdd, $userID) {
        $query = $bdd->prepare('DELETE FROM AFFINITE WHERE ID_UTILISATEUR=:userID');
        return $query->execute(['userID' => $userID]);
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