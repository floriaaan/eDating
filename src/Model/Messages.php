<?php
session_start();
// on vérifie toujours qu'il s'agit d'un membre qui est connecté
if (!isset($_SESSION['login'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: index.php');
	exit();
}




class Messages
{
    protected $table = 'T_MESSAGES'; 
    
    public function getDiscussion($currentUser, $otherUser)
    {
        $sql = 'UPDATE discussions
                SET discussions.from_user_read=:from_user_read
                WHERE (from_user=:currentUser AND to_user=:otherUser)';
        
        $this->bdd->run($sql, [
            'currentUser'    => $currentUser,
            'otherUser'      => $otherUser,
            'from_user_read' => true
        ]);
        
        $sql = 'UPDATE discussions
                SET discussions.to_user_read=:to_user_read
                WHERE (to_user=:currentUser AND from_user=:otherUser)';
        
        $this->bdd->run($sql, [
            'currentUser'  => $currentUser,
            'otherUser'    => $otherUser,
            'to_user_read' => true
        ]);
        
        $sql = 'SELECT * FROM discussions
                WHERE
                    (from_user=:currentUser AND to_user=:otherUser) OR
                    (from_user=:otherUser AND to_user=:currentUser)
                ORDER BY created_at ASC';

        return $this->bdd->run($sql, [
            'currentUser' => $currentUser,
            'otherUser'   => $otherUser,
        ]);
    }
}

session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
$msg = $bdd->prepare('SELECT * FROM messages WHERE id_destinataire = ? ORDER BY id DESC');
$msg->execute(array($_SESSION['id']));
$msg_nbr = $msg->rowCount();
?>
