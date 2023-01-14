<?php
namespace Model;
require_once(__DIR__ . '/../config.php');

class Thread {

    private $pdo;

    private $member;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

}