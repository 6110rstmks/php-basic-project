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
     * create a new thread
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

    public function getAllThreads()
    {
        $sql = "SELECT * FROM threads order by id DESC";
        $stmt = $this->pdo->query($sql);
        $threads = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $threads;
    }

    /**
     * $wordの文字を含むスレッドタイトル、スレッドのコンテンツのスレッド検索してthreadのModelを返す
     * thread.phpで使用
     * @param str $word
     * @return array|false
     */
    public function searchThread($word)
    {
        // テキストボックスに値を入れずに検索をおしたときは何も表示させない。
        if ($word == '') 
        {
            return null;
        }

        $pattern1 = '%' . $word . '%'; 
        $pattern2 = '%' . $word . '%'; 
        $sql = "SELECT * FROM threads WHERE title LIKE :pattern1 or content LIKE :pattern2 ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':pattern1', $pattern1);
        $stmt->bindValue(':pattern2', $pattern2);
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
