<?php

namespace App;

class LikeLogic {

    private $pdo;


    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLikeCountLinkedWithComment($comment_id)
    {
        $sql = 'SELECT count(*) FROM likes WHERE comment_id = :comment_id';
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('comment_id', $comment_id);
        $stmt->execute();
        $cnt = $stmt->fetchColumn();
        return $cnt;
    }
}