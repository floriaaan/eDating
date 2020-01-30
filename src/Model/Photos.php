<?php


namespace src\Model;


use Symfony\Component\Mime\Email;

class Photos
{
    private $PhotoName;
    private $PhotoDossier;

    /**
     * @return mixed
     */
    public function getPhotoName()
    {
        return $this->PhotoName;
    }

    /**
     * @param mixed $PhotoName
     * @return Photo
     */
    public function setPhotoName($PhotoName)
    {
        $this->PhotoName = $PhotoName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotoDossier()
    {
        return $this->PhotoDossier;
    }

    /**
     * @param mixed $PhotoDossier
     * @return Photo
     */
    public function setPhotoDossier($PhotoDossier)
    {
        $this->PhotoDossier = $PhotoDossier;
        return $this;
    }

    public function SqlGetAll(\PDO $bdd, $userID) {
        $query = $bdd->prepare('SELECT * FROM PHOTOS WHERE ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $userID]);
        $rSQL = $query->fetchAll();
        $listPhotos = [];
        foreach ($rSQL as $photo) {
            $p = new Photos();
            $p->setPhotoName($photo['PHO_IMG_NOM']);
            $p->setPhotoDossier($photo['PHO_IMG_LIEN']);

            $listPhotos[] = $p;
        }

        return $listPhotos;
    }

    public function SqlGetOne(\PDO $bdd, $userID, $picID){
        $query = $bdd->prepare('SELECT * FROM PHOTOS WHERE ID_UTILISATEUR =:userID AND ID_PHOTOS =:pictureID');
        $query->execute([
            'userID' => $userID,
            'pictureID' => $picID
            ]);
        $rSQL = $query->fetchAll();
        $p = new Photos();
        $p->setPhotoName($rSQL['PHO_IMG_NOM']);
        $p->setPhotoDossier($rSQL['PHO_IMG_LIEN']);

        return $p;

    }

    public function SqlUpdate(\PDO $bdd, $userID, $picID, $imgRepo, $imgName){
        try {
            /*$user = new Utilisateur();
         $userEmail = $user->SqlGetEmail($bdd, $userID);*/

            $old = new Photos();
            $old = $old->SqlGetOne($bdd, $userID, $picID);
            unlink('./uploads/images/'. $old->getPhotoDossier() . '/' . $old->getPhotoName() );

            $query = $bdd->prepare('UPDATE PHOTOS SET PHO_IMG_LIEN =:imgRepo, PHO_IMG_NOM =:imgName  WHERE ID_UTILISATEUR =:userID AND ID_PHOTOS =:picID');
            $rMsg = $query->execute([
                'imgRepo' => $imgRepo,
                'imgName' => $imgName,
                'userID' => $userID,
                'pictureID' => $picID
            ]);
            return $rMsg;
        } catch (\Exception $e) {
            return $e;
        }

    }

    public function SqlAdd(\PDO $bdd, $userID) {
        try {
            $requete = $bdd->prepare('INSERT INTO PHOTOS (ID_UTILISATEUR, PHO_IMG_LIEN, PHO_IMG_NOM) VALUES (:userID, :ImgRepo, :ImgName)');
            $requete->execute([
                'userID' => $userID,
                'ImgRepo' => $this->getPhotoDossier(),
                'ImgName' => $this->getPhotoName()
            ]);

            $return = array("result" => true, "message" => $bdd->lastInsertId());
        } catch (\Exception $e) {
            $return = array("result" => false, "message" => $e->getMessage());

        }
        return $return;
    }

    public function SqlDelete(\PDO $bdd, $userID, $picID) {
        try {
            $old = new Photos();
            $old = $old->SqlGetOne($bdd, $userID, $picID);
            unlink('./uploads/images/'. $old->getPhotoDossier() . '/' . $old->getPhotoName() );

            $query = $bdd->prepare('DELETE FROM PHOTOS WHERE ID_UTILISATEUR =:userID AND ID_PHOTOS =:pictureID');
            $rSQL = $query->execute([
                'userID' => $userID,
                'pictureID' => $picID
            ]);
            return $rSQL;
        } catch (\Exception $e) {
            return $e;
        }

    }

}