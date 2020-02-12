<?php


namespace src\Model;


use DateInterval;
use DateTime;

class Utilisateur implements \JsonSerializable
{
    private $UID;
    private $MotDePasse;
    private $Nom;
    private $Prenom;
    private $DateInscription;
    private $Email;
    private $Titre;
    private $Description;
    private $Sexe;
    private $Ville;
    private $Telephone;

    private $Campus;
    private $Situation;
    private $Age;
    private $Attirance;
    private $ProfilImgName;
    private $ProfilImgRepo;
    private $Latitude;
    private $Longitude;

    private $Photos;
    private $Affinites;
    private $Likes;
    private $Permission;
    private $Reports;


    public function SqlAdd(\PDO $bdd)
    {
        try {
            $requete = $bdd->prepare('INSERT INTO UTILISATEUR 
                (UTI_NOM, UTI_PRENOM, UTI_DATE_INSCRIPTION, UTI_EMAIL, UTI_TITRE, UTI_DESCRIPTION, UTI_SEXE, UTI_VILLE, UTI_TEL, UTI_MDP, UTI_CAMPUS, UTI_SITUATION, UTI_AGE, UTI_ATTIRANCE, UTI_IMAGE_NOM, UTI_IMAGE_LIEN, UTI_POS_LAT, UTI_POS_LONG)
                VALUES(:Nom, :Prenom, :DateInscription, :Email, :Titre, :Description, :Sexe, :Ville, :Telephone, :Mdp, :Campus, :Situation, :Age, :Attirance, :ProfilImgName, :ProfilImgRepo, :Latitude, :Longitude)');
            $requete->execute([
                'Nom' => $this->getNom(),
                'Prenom' => $this->getPrenom(),
                'DateInscription' => $this->getDateInscription(),
                'Email' => $this->getEmail(),
                'Titre' => $this->getTitre(),
                'Description' => $this->getDescription(),
                'Sexe' => $this->getSexe(),
                'Ville' => $this->getVille(),
                'Telephone' => $this->getTelephone(),
                'Mdp' => $this->getMotDePasse(),
                'Campus' => $this->getCampus(),
                'Situation' => $this->getSituation(),
                'Age' => $this->getAge(),
                'Attirance' => $this->getAttirance(),
                'ProfilImgName' => $this->getProfilImgName(),
                'ProfilImgRepo' => $this->getProfilImgRepo(),
                'Latitude' => $this->getLatitude(),
                'Longitude' => $this->getLongitude(),

            ]);
            $return = array("result" => true, "message" => $bdd->lastInsertId());
        } catch (\Exception $e) {
            $return = array("result" => false, "message" => $e->getMessage());
        }
        return $return;

    }

    public function SqlGetAll(\PDO $bdd)
    {
        $query = $bdd->prepare('SELECT * FROM UTILISATEUR');
        $query->execute();
        $arrayUser = $query->fetchAll();

        $listUser = [];
        foreach ($arrayUser as $userSQL) {
            $user = new Utilisateur();
            $user->setUID($userSQL['ID_UTILISATEUR'])
                ->setMotDePasse($userSQL['UTI_MDP'])
                ->setNom($userSQL['UTI_NOM'])
                ->setPrenom($userSQL['UTI_PRENOM'])
                ->setDateInscription($userSQL['UTI_DATE_INSCRIPTION'])
                ->setEmail($userSQL['UTI_EMAIL'])
                ->setTitre($userSQL['UTI_TITRE'])
                ->setDescription($userSQL['UTI_DESCRIPTION'])
                ->setSexe($userSQL['UTI_SEXE'])
                ->setVille($userSQL['UTI_VILLE'])
                ->setTelephone($userSQL['UTI_TEL'])
                ->setCampus($userSQL['UTI_CAMPUS'])
                ->setSituation($userSQL['UTI_SITUATION'])
                ->setAge($userSQL['UTI_AGE'])
                ->setAttirance($userSQL['UTI_ATTIRANCE'])
                ->setProfilImgName($userSQL['UTI_IMAGE_NOM'])
                ->setProfilImgRepo($userSQL['UTI_IMAGE_LIEN'])
                ->setLatitude($userSQL['UTI_POS_LAT'])
                ->setLongitude($userSQL['UTI_POS_LONG'])
                ->setPhotos((new Photos)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setLikes((new Like)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setPermission((new Permission)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setReports((new Avertissement)->SqlGetWarnedUser($bdd, $userSQL['ID_UTILISATEUR']));

            $listUser[] = $user;
        }
        return $listUser;
    }

    public function SqlGet(\PDO $bdd, $id)
    {
        $query = $bdd->prepare('SELECT * FROM UTILISATEUR WHERE ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $id]);
        $userSQL = $query->fetch();

        $user = new Utilisateur();
        $user->setUID($id)
            ->setMotDePasse($userSQL['UTI_MDP'])
            ->setNom($userSQL['UTI_NOM'])
            ->setPrenom($userSQL['UTI_PRENOM'])
            ->setDateInscription($userSQL['UTI_DATE_INSCRIPTION'])
            ->setEmail($userSQL['UTI_EMAIL'])
            ->setTitre($userSQL['UTI_TITRE'])
            ->setDescription($userSQL['UTI_DESCRIPTION'])
            ->setSexe($userSQL['UTI_SEXE'])
            ->setVille($userSQL['UTI_VILLE'])
            ->setTelephone($userSQL['UTI_TEL'])
            ->setCampus($userSQL['UTI_CAMPUS'])
            ->setSituation($userSQL['UTI_SITUATION'])
            ->setAge($userSQL['UTI_AGE'])
            ->setAttirance($userSQL['UTI_ATTIRANCE'])
            ->setProfilImgName($userSQL['UTI_IMAGE_NOM'])
            ->setProfilImgRepo($userSQL['UTI_IMAGE_LIEN'])
            ->setLatitude($userSQL['UTI_POS_LAT'])
            ->setLongitude($userSQL['UTI_POS_LONG'])
            ->setPhotos((new Photos)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
            ->setLikes((new Like)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
            ->setPermission((new Permission)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
            ->setReports((new Avertissement)->SqlGetWarnedUser($bdd, $userSQL['ID_UTILISATEUR']));
        return $user;
    }

    public function SqlGetBy(\PDO $bdd, $SQL, $param)
    {
        $query = $bdd->prepare($SQL);
        $query->execute([
            'param' => $param
        ]);
        $arrayUser = $query->fetchAll();

        $listUser = [];
        foreach ($arrayUser as $userSQL) {
            $user = new Utilisateur();
            $user->setUID($userSQL['ID_UTILISATEUR'])
                ->setMotDePasse($userSQL['UTI_MDP'])
                ->setNom($userSQL['UTI_NOM'])
                ->setPrenom($userSQL['UTI_PRENOM'])
                ->setDateInscription($userSQL['UTI_DATE_INSCRIPTION'])
                ->setEmail($userSQL['UTI_EMAIL'])
                ->setTitre($userSQL['UTI_TITRE'])
                ->setDescription($userSQL['UTI_DESCRIPTION'])
                ->setSexe($userSQL['UTI_SEXE'])
                ->setVille($userSQL['UTI_VILLE'])
                ->setTelephone($userSQL['UTI_TEL'])
                ->setCampus($userSQL['UTI_CAMPUS'])
                ->setSituation($userSQL['UTI_SITUATION'])
                ->setAge($userSQL['UTI_AGE'])
                ->setAttirance($userSQL['UTI_ATTIRANCE'])
                ->setProfilImgName($userSQL['UTI_IMAGE_NOM'])
                ->setProfilImgRepo($userSQL['UTI_IMAGE_LIEN'])
                ->setLatitude($userSQL['UTI_POS_LAT'])
                ->setLongitude($userSQL['UTI_POS_LONG'])
                ->setPhotos((new Photos)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setLikes((new Like)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setPermission((new Permission)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setReports((new Avertissement)->SqlGetWarnedUser($bdd, $userSQL['ID_UTILISATEUR']));

            $listUser[] = $user;
        }

        return $listUser;
    }

    public function SqlGetLike(\PDO $bdd, $SQL, $param)
    {
        $query = $bdd->prepare($SQL);
        $query->execute([
            'param' => "%$param%"
        ]);
        $arrayUser = $query->fetchAll();

        $listUser = [];
        foreach ($arrayUser as $userSQL) {
            $user = new Utilisateur();
            $user->setUID($userSQL['ID_UTILISATEUR'])
                ->setMotDePasse($userSQL['UTI_MDP'])
                ->setNom($userSQL['UTI_NOM'])
                ->setPrenom($userSQL['UTI_PRENOM'])
                ->setDateInscription($userSQL['UTI_DATE_INSCRIPTION'])
                ->setEmail($userSQL['UTI_EMAIL'])
                ->setTitre($userSQL['UTI_TITRE'])
                ->setDescription($userSQL['UTI_DESCRIPTION'])
                ->setSexe($userSQL['UTI_SEXE'])
                ->setVille($userSQL['UTI_VILLE'])
                ->setTelephone($userSQL['UTI_TEL'])
                ->setCampus($userSQL['UTI_CAMPUS'])
                ->setSituation($userSQL['UTI_SITUATION'])
                ->setAge($userSQL['UTI_AGE'])
                ->setAttirance($userSQL['UTI_ATTIRANCE'])
                ->setProfilImgName($userSQL['UTI_IMAGE_NOM'])
                ->setProfilImgRepo($userSQL['UTI_IMAGE_LIEN'])
                ->setLatitude($userSQL['UTI_POS_LAT'])
                ->setLongitude($userSQL['UTI_POS_LONG'])
                ->setPhotos((new Photos)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setLikes((new Like)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setPermission((new Permission)->SqlGetAll($bdd, $userSQL['ID_UTILISATEUR']))
                ->setReports((new Avertissement)->SqlGetWarnedUser($bdd, $userSQL['ID_UTILISATEUR']));

            $listUser[] = $user;
        }

        return $listUser;
    }

    public function SqlResetPass(\PDO $bdd, $email, $pass)
    {
        /*$query = $bdd->prepare('UPDATE UTILISATEUR SET UTI_MDP =:param2 WHERE UTI_EMAIL =:param1');
        return $query->execute([
            'param1' => $email,
            'param2' => $pass
        ]);*/

        $emailToUID = $bdd->prepare('SELECT ID_UTILISATEUR FROM UTILISATEUR WHERE UTI_EMAIL =:email');
        $emailToUID->execute(['email'=>$email]);
        $UID = $emailToUID->fetch();

        $testIfEmpty = $bdd->prepare('SELECT * FROM TOKEN WHERE ID_TOK_EMAIL =:email');
        $testIfEmpty->execute(['email'=>$email]);
        $testIfEmpty = $testIfEmpty->fetchAll();

        if(empty($testIfEmpty)) {
            $query = $bdd->prepare('INSERT INTO TOKEN (TOK_DATE_VALID, TOK_CLEF, ID_TOK_EMAIL, ID_UTILISATEUR) VALUES (:DateValid, :Token, :Email, :UID)');
            return $query->execute([
                'DateValid' => (new DateTime)->modify('+1 day')->format('Y-m-d'),
                'Token' => $pass,
                'Email' => $email,
                'UID' => $UID['ID_UTILISATEUR']
            ]);
        } else {
            $query = $bdd->prepare('UPDATE TOKEN SET TOK_DATE_VALID =:DateValid, TOK_CLEF =:Token WHERE ID_TOK_EMAIL=:Email AND ID_UTILISATEUR =:UID');
            return $query->execute([
                'DateValid' => (new DateTime)->modify('+1 day')->format('Y-m-d'),
                'Token' => $pass,
                'Email' => $email,
                'UID' => $UID['ID_UTILISATEUR']
            ]);
        }


    }

    public function SqlResetPassFromMail(\PDO $bdd, $email, $pass, $id)
    {
        $query = $bdd->prepare('SELECT * FROM TOKEN WHERE ID_TOK_EMAIL=:email');
        $query->execute(['email' => $email]);
        $tok = $query->fetch();

        $dateNow = new DateTime();
        $dateNow =$dateNow->format('Y-m-d');
        $dateValid = date('Y-m-d' ,strtotime($tok['TOK_DATE_VALID']));


        if ($id == $tok['TOK_CLEF'] && $dateNow <= $dateValid) {
            $query = $bdd->prepare('UPDATE UTILISATEUR SET UTI_MDP =:param2 WHERE UTI_EMAIL =:param1');
            $rSQL = $query->execute([
                'param1' => $email,
                'param2' => password_hash($pass, PASSWORD_BCRYPT)
            ]);
            if ($rSQL) {
                $query = $bdd->prepare('DELETE FROM TOKEN WHERE ID_TOK_EMAIL =:Email');
                return $query->execute(['Email' => $email]);

            } else {
                return false;
            }

        } else {
            return false;
        }


    }

    public function SqlGetEmailFromToken(\PDO $bdd, $id)
    {
        $query = $bdd->prepare('SELECT ID_TOK_EMAIL FROM TOKEN WHERE TOK_CLEF=:param1');
        $query->execute(['param1' => $id]);
        $userEmail = $query->fetch();
        return $userEmail['ID_TOK_EMAIL'];
    }


    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->Likes;
    }

    /**
     * @param mixed $Likes
     * @return Utilisateur
     */
    public function setLikes($Likes)
    {
        $this->Likes = $Likes;
        return $this;
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
     * @return Utilisateur
     */
    public function setAffinites($Affinites)
    {
        $this->Affinites = $Affinites;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->Photos;
    }

    /**
     * @param mixed $Photos
     * @return Utilisateur
     */
    public function setPhotos($Photos)
    {
        $this->Photos = $Photos;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getUID()
    {
        return $this->UID;
    }

    /**
     * @param mixed $UID
     * @return Utilisateur
     */
    public function setUID($UID)
    {
        $this->UID = $UID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->Nom;
    }

    /**
     * @param mixed $Nom
     * @return Utilisateur
     */
    public function setNom($Nom)
    {
        $this->Nom = $Nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->Prenom;
    }

    /**
     * @param mixed $Prenom
     * @return Utilisateur
     */
    public function setPrenom($Prenom)
    {
        $this->Prenom = $Prenom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        return $this->DateInscription;
    }

    /**
     * @param mixed $DateInscription
     * @return Utilisateur
     */
    public function setDateInscription($DateInscription)
    {
        $this->DateInscription = $DateInscription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     * @return Utilisateur
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param mixed $Description
     * @return Utilisateur
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSexe()
    {
        return $this->Sexe;
    }

    /**
     * @param mixed $Sexe
     * @return Utilisateur
     */
    public function setSexe($Sexe)
    {
        $this->Sexe = $Sexe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->Telephone;
    }

    /**
     * @param mixed $Telephone
     * @return Utilisateur
     */
    public function setTelephone($Telephone)
    {
        $this->Telephone = $Telephone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->Titre;
    }

    /**
     * @param mixed $Titre
     * @return Utilisateur
     */
    public function setTitre($Titre)
    {
        $this->Titre = $Titre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->Latitude;
    }

    /**
     * @param mixed $Latitude
     * @return Utilisateur
     */
    public function setLatitude($Latitude)
    {
        $this->Latitude = $Latitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->Longitude;
    }

    /**
     * @param mixed $Longitude
     * @return Utilisateur
     */
    public function setLongitude($Longitude)
    {
        $this->Longitude = $Longitude;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getMotDePasse()
    {
        return $this->MotDePasse;
    }

    /**
     * @param mixed $MotDePasse
     * @return Utilisateur
     */
    public function setMotDePasse($MotDePasse)
    {
        $this->MotDePasse = $MotDePasse;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->Ville;
    }

    /**
     * @param mixed $Ville
     * @return Utilisateur
     */
    public function setVille($Ville)
    {
        $this->Ville = $Ville;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->Campus;
    }

    /**
     * @param mixed $Campus
     * @return Utilisateur
     */
    public function setCampus($Campus)
    {
        $this->Campus = $Campus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSituation()
    {
        return $this->Situation;
    }

    /**
     * @param mixed $Situation
     * @return Utilisateur
     */
    public function setSituation($Situation)
    {
        $this->Situation = $Situation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->Age;
    }

    /**
     * @param mixed $Age
     * @return Utilisateur
     */
    public function setAge($Age)
    {
        $this->Age = $Age;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfilImgName()
    {
        return $this->ProfilImgName;
    }

    /**
     * @param mixed $ProfilImgName
     * @return Utilisateur
     */
    public function setProfilImgName($ProfilImgName)
    {
        $this->ProfilImgName = $ProfilImgName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfilImgRepo()
    {
        return $this->ProfilImgRepo;
    }

    /**
     * @param mixed $ProfilImgRepo
     * @return Utilisateur
     */
    public function setProfilImgRepo($ProfilImgRepo)
    {
        $this->ProfilImgRepo = $ProfilImgRepo;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getAttirance()
    {
        return $this->Attirance;
    }

    /**
     * @param mixed $Attirance
     * @return Utilisateur
     */
    public function setAttirance($Attirance)
    {
        $this->Attirance = $Attirance;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getPermission()
    {
        return $this->Permission;
    }

    /**
     * @param mixed $Permission
     * @return Utilisateur
     */
    public function setPermission($Permission)
    {
        $this->Permission = $Permission;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getReports()
    {
        return $this->Reports;
    }

    /**
     * @param mixed $Reports
     * @return Utilisateur
     */
    public function setReports($Reports)
    {
        $this->Reports = $Reports;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'UID' => $this->getUID(),
            'Password' => $this->getMotDePasse(),
            'Nom' => $this->getNom(),
            'Prenom' => $this->getPrenom(),
            'DateInscription' => $this->getDateInscription(),
            'Email' => $this->getEmail(),
            'Titre' => $this->getTitre(),
            'Description' => $this->getDescription(),
            'Sexe' => $this->getSexe(),
            'Ville' => $this->getVille(),
            'Telephone' => $this->getTelephone(),
            'Campus' => $this->getCampus(),
            'Situation' => $this->getSituation(),
            'Age' => $this->getAge(),
            'Attirance' => $this->getAttirance(),
            'ProfilImgName' => $this->getProfilImgName(),
            'ProfilImgRepo' => $this->getProfilImgRepo(),
            'Latitude' => $this->getLatitude(),
            'Longitude' => $this->getLatitude(),
            'Photos' => $this->getPhotos(),
            'Affinites' => $this->getAffinites(),
            'Likes' => $this->getLikes(),
            'Permissions' =>$this->getPermission(),
            'Reports' => $this->getReports()
        ];
    }

}