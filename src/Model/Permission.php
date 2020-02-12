<?php


namespace src\Model;


class Permission
{

    private $pID;
    private $Type;
    private $Active;


    public function SqlGetAll(\PDO $bdd, $userID)
    {
        $query = $bdd->prepare('SELECT * FROM PERMISSION WHERE ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $userID]);
        $rSQL = $query->fetchAll();
        $listPerms = [];
        foreach ($rSQL as $perm) {
            $p = new Permission();
            $p->setPID($perm['ID_PERMISSION'])
                ->setType($perm['PER_TYPE'])
                ->setActive($perm['PER_ACTIF']);

            $listPerms[] = $p;
        }

        return $listPerms;
    }

    public function SqlUpdate(\PDO $bdd, $permID)
    {
        $query = $bdd->prepare('UPDATE PERMISSION SET PER_TYPE =:Type, PER_ACTIF =:Actif WHERE ID_PERMISSION =:ID');
        return $query->execute([
            'ID' => $permID,
            'Type' => $this->getType(),
            'Actif' => $this->getActive()
        ]);
    }

    public function SqlAdd(\PDO $bdd, $userID)
    {
        try {
            $query = $bdd->prepare('INSERT INTO PERMISSION (ID_UTILISATEUR, PER_TYPE, PER_ACTIF) VALUES (:UID, :Type, :Actif)');
            $query->execute([
                'UID' => $userID,
                'Type' => $this->getType(),
                'Actif' => $this->getActive()
            ]);
            $return = array("result" => true, "message" => $bdd->lastInsertId());
        } catch (\Exception $e) {
            $return = array("result" => false, "message" => $e->getMessage());

        }
        return $return;
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
     * @return Permission
     */
    public function setType($Type)
    {
        $this->Type = $Type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->Active;
    }

    /**
     * @param mixed $Active
     * @return Permission
     */
    public function setActive($Active)
    {
        $this->Active = $Active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPID()
    {
        return $this->pID;
    }

    /**
     * @param mixed $pID
     * @return Permission
     */
    public function setPID($pID)
    {
        $this->pID = $pID;
        return $this;
    }
}