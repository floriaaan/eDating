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
            $listLikes[] = $like['UTI_ID_UTILISATEUR'];
        }

        return $listLikes;
    }

    public function SqlGetLikedMe(\PDO $bdd, $userID) {
        $query = $bdd->prepare('SELECT * FROM AIME WHERE UTI_ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $userID]);
        $rSQL = $query->fetchAll();
        $listLikes = [];
        foreach ($rSQL as $like) {
            $listLikes[] = $like['ID_UTILISATEUR'];
        }

        return $listLikes;
    }

    public function SqlDelete(\PDO $bdd, $userID, $likeID)
    {
        $query = $bdd->prepare('DELETE FROM AIME WHERE UTI_ID_UTILISATEUR =:likeID AND ID_UTILISATEUR =:userID');
        return $query->execute([
            'likeID' => $likeID,
            'userID' => $userID]);
    }

    public function SqlAdd(\PDO $bdd, $userID)
    {
        try {
            $query = $bdd->prepare('INSERT INTO AIME (ID_UTILISATEUR, UTI_ID_UTILISATEUR) VALUES (:userID, :likeID)');
            $query->execute([
                'userID' => $userID,
                'likeID' => $this->getUserLiked()]);
            $return = array("result" => true, "message" => $bdd->lastInsertId());
        } catch (\Exception $e) {
            $return = array("result" => false, "message" => $e->getMessage());

        }
        return $return;
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