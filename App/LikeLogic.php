<?php

namespace App;

class LikeLogic {

    private $pdo;


    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}