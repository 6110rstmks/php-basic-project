<?php

namespace App;

class ThreadLogic {

    private $pdo;

    private $member;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // ボツ
    // public function setMember(Member $member)
    // {
    //     $this->member = $member;
    // }

    /**
     * 
     * @param string $email
     * @return bool
     */
    // public function checkEmailExist($data)
    // {
    //     $sql = 'SELECT * FROM members WHERE email = :data';

    //     $stmt = $this->pdo->prepare($sql);

    //     // $stmt->execute();
    //     $stmt->execute(array(
    //         ':data' => $data,
    //     ));

    //     $user = $stmt->fetchAll();

    //     return $user;
    // }

    /**
     * 
     * @param array $threadData, int $member_id
     * 
     */
    public function createThread(array $threadData, int $id)
    {

        

        $sql = 'INSERT INTO threads (member_id, title, content, created_at) VALUES (:member_id, :title, :content, now())';

        $arr = [];

        $title = $threadData['title'];

        $comment = $threadData['comment'];

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('title', $title);
        $stmt->bindValue('content', $comment);
        $stmt->bindValue('member_id', $id);

        $stmt->execute();
    }

    /**
     * ワードからスレッド検索してthreadのModelを返す
     * @param str $word
     * @return array
     */
    public function searchThread($word)
    {
        $pattern = '%' . $word . '%'; 
        $sql = "SELECT * FROM threads WHERE title LIKE :pattern ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':pattern', $pattern);
        $stmt->execute();

        $threads = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $threads;
    }

    /**
     * 
     * idからスレッドを取得する
     * 
     */
    public function getThreadById($id)
    {
        $sql = "SELECT * FROM threads WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $thread = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $thread;
    }

    /**
     * 
     */
    public function prevThreadCheck($threadId)
    {
        $threadId -=1;
        $sql = 'SELECT * FROM threads WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $threadId);

        $stmt->execute();

        $prevThread = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($prevThread != false)
        {
            return true;
        }

        return false;

    }

    public function nextThreadCheck($threadId)
    {
        $threadId +=1;
        $sql = 'SELECT * FROM threads WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $threadId);

        $stmt->execute();

        $prevThread = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($prevThread != false)
        {
            return true;
        }

        return false;
    }


}
