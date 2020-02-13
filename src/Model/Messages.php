<?php

namespace src\Model;

use src\Model\Bdd;

Class Messages
{


    private $ID_MESSAGE;
    private $ID_UTILISATEUR;
    private $UTI_ID_UTILISATEUR;
    private $MES_DATE;
    private $MES_CONTENU;
    private $MES_LU;


    public function selectMesParId($idMessage)
    {

        $bdd = Bdd::GetInstance();
        $requete = $bdd->prepare("SELECT MES_CONTENU
        FROM MESSAGE
        WHERE ID_MESSAGE=?;");
        $requete->execute(array($idMessage));
        $reponse = $requete->fetch();
        return $reponse;
    }

    public function afficherAncienMsg($userid, $contactid)
    {

        $bdd = Bdd::GetInstance();
        $afficher = $bdd->prepare("SELECT * FROM MESSAGE
        WHERE ID_UTILISATEUR LIKE ? OR ID_UTILISATEUR LIKE  ?
        AND UTI_ID_UTILISATEUR LIKE ? OR UTI_ID_UTILISATEUR LIKE ?
        ORDER BY MES_DATE LIMIT 50;");
        $afficher->execute(array($userid, $contactid, $contactid, $userid));
        $msg = $afficher->fetchAll();
        $afficher->closeCursor();

        return $msg;
    }

    public function envoyerMsg($userid, $contactid, $msg)
    {

        $bdd = Bdd::GetInstance();
        $envoyer = $bdd->prepare("INSERT INTO `MESSAGE` (`ID_UTILISATEUR`, `UTI_ID_UTILISATEUR`, `MES_CONTENU`) 
        VALUES (:userid, :contactid, :contenu)");
        $rSql = $envoyer->execute([
            'userid' => $userid,
            'contactid' => $contactid,
            'contenu' => $msg
        ]);
        return $rSql;

    }

    public function getLastMsg(\PDO $bdd, $transmitterUserID, $meUserID)
    {
        $query = $bdd->prepare('SELECT * FROM MESSAGE WHERE (ID_UTILISATEUR =:MUID AND UTI_ID_UTILISATEUR =:TUID)
                         OR (ID_UTILISATEUR =:TUID AND UTI_ID_UTILISATEUR =:MUID) ORDER BY MES_DATE DESC LIMIT 1');
        $query->execute([
            'MUID' => $meUserID,
            'TUID' => $transmitterUserID
        ]);
        $rSql = $query->fetch();
        return $rSql;
    }

    public function SqlGetUnreadByUser(\PDO $bdd, $UserID)
    {
        $query = $bdd->prepare('SELECT * FROM MESSAGE 
                        WHERE UTI_ID_UTILISATEUR =:MUID AND MES_LU = 0 ORDER BY MES_DATE DESC');
        $query->execute([
            'MUID' => $UserID
        ]);
        $rSql = $query->fetchAll();
        return $rSql;
    }

    public function SqlSetToReadMsg(\PDO $bdd, $transmitterUserID, $meUserID)
    {
        $query = $bdd->prepare('SELECT * FROM MESSAGE 
                        WHERE (ID_UTILISATEUR =:TUID AND UTI_ID_UTILISATEUR =:MUID) AND MES_LU = 0');
        $query->execute([
            'MUID' => $meUserID,
            'TUID' => $transmitterUserID
        ]);
        $ListMessage = $query->fetchAll();
        $rValue = true;
        foreach ($ListMessage as $message) {

            $updateQuery = $bdd->prepare('UPDATE MESSAGE SET MES_LU = 1 WHERE ID_MESSAGE =:ID');
            $rSql = $updateQuery->execute(['ID' => $message['ID_MESSAGE']]);

            $rValue = ($rSql != false);
        }

        return $rValue;
    }


    /**
     * Get the value of ID_MESSAGE
     */
    public function getID_MESSAGE()
    {
        return $this->ID_MESSAGE;
    }

    /**
     * Set the value of ID_MESSAGE
     *
     * @return  self
     */
    public function setID_MESSAGE($ID_MESSAGE)
    {
        $this->ID_MESSAGE = $ID_MESSAGE;

        return $this;
    }

    /**
     * Get the value of ID_UTILISATEUR
     */
    public function getID_UTILISATEUR()
    {
        return $this->ID_UTILISATEUR;
    }

    /**
     * Set the value of ID_UTILISATEUR
     *
     * @return  self
     */
    public function setID_UTILISATEUR($ID_UTILISATEUR)
    {
        $this->ID_UTILISATEUR = $ID_UTILISATEUR;

        return $this;
    }

    /**
     * Get the value of UTI_ID_UTILISATEUR
     */
    public function getUTI_ID_UTILISATEUR()
    {
        return $this->UTI_ID_UTILISATEUR;
    }

    /**
     * Set the value of UTI_ID_UTILISATEUR
     *
     * @return  self
     */
    public function setUTI_ID_UTILISATEUR($UTI_ID_UTILISATEUR)
    {
        $this->UTI_ID_UTILISATEUR = $UTI_ID_UTILISATEUR;

        return $this;
    }

    /**
     * Get the value of MES_DATE
     */
    public function getMES_DATE()
    {
        return $this->MES_DATE;
    }

    /**
     * Set the value of MES_DATE
     *
     * @return  self
     */
    public function setMES_DATE($MES_DATE)
    {
        $this->MES_DATE = $MES_DATE;

        return $this;
    }

    /**
     * Get the value of MES_CONTENU
     */
    public function getMES_CONTENU()
    {
        return $this->MES_CONTENU;
    }

    /**
     * Set the value of MES_CONTENU
     *
     * @return  self
     */
    public function setMES_CONTENU($MES_CONTENU)
    {
        $this->MES_CONTENU = $MES_CONTENU;

        return $this;
    }

    /**
     * Get the value of MES_LU
     */
    public function getMES_LU()
    {
        return $this->MES_LU;
    }

    /**
     * Set the value of MES_LU
     *
     * @return  self
     */
    public function setMES_LU($MES_LU)
    {
        $this->MES_LU = $MES_LU;

        return $this;
    }
}
