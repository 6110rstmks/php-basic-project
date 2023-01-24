<?php

namespace App;

class LikeLogic {

    private $pdo;


    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * like_toggle.phpで使用
     * @
     * @return true|false
     */
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

    /**
     * 
     * @return int
     */
    public function getLikeCountLinkedWithComment($comment_id)
    {
        $sql = 'SELECT count(*) FROM likes WHERE comment_id = :comment_id';
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('comment_id', $comment_id);
        $stmt->execute();
        $cnt = $stmt->fetchColumn();
        return $cnt;
    }

    /**
     * 自分がスレッドに付属するコメントにいいねをすると、いいねが作成される。
     * ただし、そのコメントにいいねを既にしていた場合、いいねが削除される（レコードが削除される）
     */
    public function createLikeRecord($member_id, $comment_id)
    {
        $sql = 'INSERT INTO likes (member_id, comment_id) VALUES (:member_id, :comment_id)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':member_id', $member_id);
        $stmt->bindValue(':comment_id', $comment_id);

        $stmt->execute();
    }

    /**
     * 自分がいいねしたいいねボタンをもう一度押すと、いいねレコードが消える。
     */
    public function deleteLikeRecord($member_id, $comment_id)
    {
        $sql = 'DELETE FROM likes WHERE member_id = (:member_id) and comment_id = (:comment_id)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':member_id', $member_id);
        $stmt->bindValue(':comment_id', $comment_id);

        $stmt->execute();
    }
}