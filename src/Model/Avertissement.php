<?php


namespace src\Model;


class Avertissement
{

    private $wID;
    private $Contenu;
    private $Date;
    private $Type;


    public function SqlGetWarnedUser(\PDO $bdd, $userID)
    {
        $query = $bdd->prepare('SELECT * FROM SIGNALEMENT WHERE UTI_ID_UTILISATEUR =:UID');
        $query->execute(['UID' => $userID]);
        $rSql = $query->fetchAll();

        $listWarn = [];
        foreach ($rSql as $warn) {
            $w = new Avertissement();
            $w->setType($warn['SIG_TYPE'])
                ->setContenu($warn['SIG_CONTENU'])
                ->setDate($warn['SIG_DATE'])
                ->setWID($warn['ID_SIGNALEMENT']);

            $listWarn[] = $w;
        }

        return $listWarn;
    }

    public function SqlGet(\PDO $bdd, $warnID) {
        $query = $bdd->prepare('SELECT * FROM SIGNALEMENT WHERE ID_SIGNALEMENT =:ID');
        $query->execute(['ID' => $warnID]);
        $rSql = $query->fetch();
        $w = new Avertissement();
        $w->setType($rSql['SIG_TYPE'])
            ->setContenu($rSql['SIG_CONTENU'])
            ->setDate($rSql['SIG_DATE'])
            ->setWID($rSql['ID_SIGNALEMENT']);

        return $w;
    }

    public function SqlAdd(\PDO $bdd, $userID, $sessionID)
    {
        try {
            $query = $bdd->prepare('INSERT INTO SIGNALEMENT (ID_UTILISATEUR, UTI_ID_UTILISATEUR, SIG_CONTENU, SIG_DATE, SIG_TYPE) VALUES (:MUID, :UID, :Contenu, :Date, :Type)');
            $query->execute([
                'MUID' => $sessionID,
                'UID' => $userID,
                'Contenu' => $this->getContenu(),
                'Date' => $this->getDate(),
                'Type' => $this->getType()
            ]);
            $return = array("result" => true, "message" => $bdd->lastInsertId());
        } catch (\Exception $e) {
            $return = array("result" => false, "message" => $e->getMessage());

        }
        return $return;
    }

    public function SqlDelete(\PDO $bdd, $warnID)
    {
        try {
            $query = $bdd->prepare('DELETE FROM SIGNALEMENT WHERE ID_SIGNALEMENT =:warnID');
            $rSQL = $query->execute([
                'warnID' => $warnID
            ]);
            return $rSQL;
        } catch (\Exception $e) {
            return $e;
        }
    }


    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->Contenu;
    }

    /**
     * @param mixed $Contenu
     * @return Avertissement
     */
    public function setContenu($Contenu)
    {
        $this->Contenu = $Contenu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param mixed $Date
     * @return Avertissement
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     * @return Avertissement
     */
    public function setType($Type)
    {
        $this->Type = $Type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWID()
    {
        return $this->wID;
    }

    /**
     * @param mixed $wID
     * @return Avertissement
     */
    public function setWID($wID)
    {
        $this->wID = $wID;
        return $this;
    }

}