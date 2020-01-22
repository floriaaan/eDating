<?php





class Messages
{
    protected $table = 'discussions';
    
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