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
        $sql = 'INSERT INTO threads (title, content) VALUES (?, ?)';

        $arr = [];

        $arr[] = $threadData['title'];
        $arr[] = $threadData['comment'];

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($arr);
    }
}
