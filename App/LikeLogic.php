<?php

namespace App;

class LikeLogic {

    private $pdo;


    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function checkLikeRecord($member_id, $comment_id)
    {
        $sql = 'SELECT * from likes WHERE member_id = :member_id and comment_id = :comment_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':member_id', $member_id);
        $stmt->bindValue(':comment_id', $comment_id);

        $stmt->execute();

        $like = $stmt->fetch(\PDO::FETCH_ASSOC);
         
        if ($like != false)
        {
            return true;
        } else {
            return $like;
        }



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

    public function createLikeRecord($member_id, $comment_id)
    {
        $sql = 'INSERT INTO likes (member_id, comment_id) VALUES (:member_id, :comment_id)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':member_id', $member_id);
        $stmt->bindValue(':comment_id', $comment_id);

        $stmt->execute();
    }

    public function deleteLikeRecord($member_id, $comment_id)
    {
        $sql = 'DELETE FROM likes WHERE member_id = (:member_id) and comment_id = (:comment_id)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':member_id', $member_id);
        $stmt->bindValue(':comment_id', $comment_id);

        $stmt->execute();
    }
}