<?php


namespace src\Model;


class Like
{
    private $userLiked;



    public function SqlGetAll(\PDO $bdd, $userID) {
        $query = $bdd->prepare('SELECT * FROM AIME WHERE ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $userID]);
        $rSQL = $query->fetchAll();
        $listLikes = [];
        foreach ($rSQL as $like) {
            $l = new Like();
            $l->setAffinites($like['UTI_ID_UTILISATEUR']);

            $listLikes[] = $l;
        }

        return $listLikes;
    }






    /**
     * @return mixed
     */
    public function getUserLiked()
    {
        return $this->userLiked;
    }

    /**
     * @param mixed $userLiked
     * @return Like
     */
    public function setUserLiked($userLiked)
    {
        $this->userLiked = $userLiked;
        return $this;
    }

}