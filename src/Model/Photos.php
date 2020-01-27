<?php


namespace src\Model;


class Photos
{
    private $listPhotosName;
    private $listPhotosDossier;

    /**
     * @return mixed
     */
    public function getListPhotosName()
    {
        return $this->listPhotosName;
    }

    /**
     * @param mixed $listPhotosName
     * @return Photos
     */
    public function setListPhotosName($listPhotosName)
    {
        $this->listPhotosName = $listPhotosName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListPhotosDossier()
    {
        return $this->listPhotosDossier;
    }

    /**
     * @param mixed $listPhotosDossier
     * @return Photos
     */
    public function setListPhotosDossier($listPhotosDossier)
    {
        $this->listPhotosDossier = $listPhotosDossier;
        return $this;
    }

    public function SqlGet(\PDO $bdd, $userID) {

    }

}