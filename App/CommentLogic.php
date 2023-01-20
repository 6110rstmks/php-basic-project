<?php

namespace App;

class CommentLogic {

    private $pdo;


    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 
     * @param int $threadId, int $memberId
     */
    public function createComment($memberId, $threadId, $comment)
    {

        $timeArray = getdate(time());

        $sql = 'INSERT INTO comments (member_id, thread_id, comment, created_at) VALUES (:member_id, :thread_id, :comment, now())';

        $arr = [];

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':member_id', $memberId);
        $stmt->bindValue(':thread_id', $threadId);
        $stmt->bindValue(':comment', $comment);

        $stmt->execute();
    
    }

    /**
     * コメントをしたメンバの情報を取得するためのメソッド
     * 
     */
    public function getMemberLinkedWithComment($member_id)
    {
        $sql = 'SELECT * FROM members WHERE id = :member_id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('member_id', $member_id);
        $stmt->execute();

        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $member;

    }

    /**
     * あるスレッドに投稿されたコメント数を取得
     * @param int $thread_id
     * @return int $cnt
     */
    public function getCommentCountLinkedWithThread($thread_id)
    {
        $sql = 'SELECT count(*) FROM comments WHERE thread_id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $thread_id);
        $stmt->execute();

        $cnt = $stmt->fetchColumn();

        return $cnt;
    }

    /**
     * あるスレッドに投稿された
     * getCommentCountLinkedWithThreadはコメント数を取得するのに対し
     * このメソッドはモデル？を取得する
     * 
     */
    public function getCommentsLinkedWithThread($thread_id, $offset)
    {
        // $sql = 'SELECT * FROM comments WHERE thread_id = :id';
        $sql = "SELECT * FROM comments WHERE thread_id = :id LIMIT 5 OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $thread_id);

        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $comments = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $comments;
    }
}