<?php
namespace Model;
require_once(__DIR__ . '/../config.php');

class Member {

    private $pdo;

    private $member;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 
     */
    public function getMemberById($id)
    {
        $sql = 'SELECT * FROM members Where id = :id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        $this->member = $stmt->fetchObject();
    }
}