<?php


namespace src\Model;


class Utilisateur implements \JsonSerializable
{
    private $UID;
    private $Nom;
    private $Prenom;
    private $DateInscription;
    private $Email;
    private $Description;
    private $Sexe;
    private $Travail;
    private $estConnecte;
    private $Telephone;
    private $Titre;
    private $Latitude;
    private $Longitude;
    private $MotDePasse;









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
    public function getTravail()
    {
        return $this->Travail;
    }

    /**
     * @param mixed $Travail
     * @return Utilisateur
     */
    public function setTravail($Travail)
    {
        $this->Travail = $Travail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstConnecte()
    {
        return $this->estConnecte;
    }

    /**
     * @param mixed $estConnecte
     * @return Utilisateur
     */
    public function setEstConnecte($estConnecte)
    {
        $this->estConnecte = $estConnecte;
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
            'Description' => $this->getDescription(),
            'Sexe' => $this->getSexe(),
            'Travail' => $this->getTravail(),
            'estConnecte' => $this->getEstConnecte(),
            'Telephone' => $this->getTelephone(),
            'Titre' => $this->getTitre(),
            'Latitude' => $this->getLatitude(),
            'Longitude' => $this->getLatitude()
        ];
    }



    public function SqlAdd(\PDO $bdd) {
        try{
            $requete = $bdd->prepare('INSERT INTO T_UTILISATEUR (UTI_NOM, UTI_PRENOM, UTI_DATE_INSCRIPTION, UTI_EMAIL, UTI_DESCRIPTION, UTI_SEXE, UTI_TRAVAIL, UTI_CONNECTE, UTI_TEL, UTI_TITRE, UTI_POS_LAT, UTI_POS_LONG, UTI_MDP) VALUES(:Nom, :Prenom, :DateInscription, :Email, :Description, :Sexe, :Travail, :estConnecte, :Telephone, :Titre, :Latitude, :Longitude, :Mdp)');
            $requete->execute([
                'Nom' => $this->getNom(),
                'Prenom' => $this->getPrenom(),
                'DateInscription' => $this->getDateInscription(),
                'Email' => $this->getEmail(),
                'Description' => $this->getDescription(),
                'Sexe' => $this->getSexe(),
                'Travail' => $this->getTravail(),
                'estConnecte' => $this->getEstConnecte(),
                'Telephone' => $this->getTelephone(),
                'Titre' => $this->getTitre(),
                'Latitude' => $this->getLatitude(),
                'Longitude' => $this->getLatitude(),
                'Mdp' => $this->getMotDePasse()
            ]);
            return array("result"=>true,"message"=>$bdd->lastInsertId());
        }catch (\Exception $e){
            return array("result"=>false,"message"=>$e->getMessage());
        }

    }

    public function SqlGetAll(\PDO $bdd){
        $query = $bdd->prepare('SELECT * FROM T_UTILISATEUR');
        $query->execute();
        $arrayUser = $query->fetchAll();

        $listUser = [];
        foreach ($arrayUser as $userSQL){
            $user = new Utilisateur();
            $user->setUID($userSQL['ID_UTILISATEUR']);
            $user->setNom($userSQL['UTI_NOM']);
            $user->setPrenom($userSQL['UTI_PRENOM']);
            $user->setDateInscription($userSQL['UTI_DATE_INSCRIPTION']);
            $user->setEmail($userSQL['UTI_EMAIL']);
            $user->setDescription($userSQL['UTI_DESCRIPTION']);
            $user->setSexe($userSQL['UTI_SEXE']);
            $user->setTravail($userSQL['UTI_TRAVAIL']);
            $user->setEstConnecte($userSQL['UTI_CONNECTE']);
            $user->setTelephone($userSQL['UTI_TEL']);
            $user->setTitre($userSQL['UTI_TITRE']);
            $user->setLatitude($userSQL['UTI_POS_LAT']);
            $user->setLongitude($userSQL['UTI_POS_LONG']);
            $user->setMotDePasse($userSQL['UTI_MDP']);

            $listUser[] = $user;
        }
        return $listUser;
    }

    public function SqlGet(\PDO $bdd, $id){
        $query = $bdd->prepare('SELECT * FROM T_UTILISATEUR WHERE ID_UTILISATEUR =:ID');
        $query->execute(['ID' => $id]);
        $userSQL = $query->fetch();

        $user = new Utilisateur();
        $user->setUID($userSQL['ID_UTILISATEUR']);
        $user->setNom($userSQL['UTI_NOM']);
        $user->setPrenom($userSQL['UTI_PRENOM']);
        $user->setDateInscription($userSQL['UTI_DATE_INSCRIPTION']);
        $user->setEmail($userSQL['UTI_EMAIL']);
        $user->setDescription($userSQL['UTI_DESCRIPTION']);
        $user->setSexe($userSQL['UTI_SEXE']);
        $user->setTravail($userSQL['UTI_TRAVAIL']);
        $user->setEstConnecte($userSQL['UTI_CONNECTE']);
        $user->setTelephone($userSQL['UTI_TEL']);
        $user->setTitre($userSQL['UTI_TITRE']);
        $user->setLatitude($userSQL['UTI_POS_LAT']);
        $user->setLongitude($userSQL['UTI_POS_LONG']);
        $user->setMotDePasse($userSQL['UTI_MDP']);

        return $user;
    }
}