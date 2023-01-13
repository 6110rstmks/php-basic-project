<?php

namespace App;

class ThreadLogic {

    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 
     * @param string $email
     * @return bool
     */
    public function checkEmailExist($data)
    {
        $sql = 'SELECT * FROM members WHERE email = :data';

        $stmt = $this->pdo->prepare($sql);

        // $stmt->execute();
        $stmt->execute(array(
            ':data' => $data,
        ));

        $user = $stmt->fetchAll();

        return $user;
    }

    public function createThread(array $threadData)
    {
        // $result = false; 
        // $sql = 'INSERT INTO threads (title, content, created_at) VALUES (?, ?, now())';
        $sql = 'INSERT INTO threads (title, content, created_at) VALUES (:title, :content, now())';

        $arr = [];

        $title = $threadData['title'];

        $comment = $threadData['comment'];



        // $arr[] = $threadData['title'];
        // $arr[] = $threadData['comment'];



        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('title', $title);
        $stmt->bindValue('content', $comment);


        // $stmt->execute($arr);
        $stmt->execute();
    }

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
}
