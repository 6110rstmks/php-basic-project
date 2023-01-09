<?php

namespace App;

class UserLogic {

    private $pdo;

    function __constructor($pdo)
    {
        $this->pdo = $pdo;
    }

    public static function createUser(array $userData): bool
    {
        $result = false;
        $sql = 'INSERT INTO users (lastname, first_name, sex, prefecture, other_address, password, password_cnf, email) VALUES (?, ?, ?, ?, ?, ?, ?)';

        // put userData into array

        $arr = [];

        $arr[] = $userData['name'];

        $arr[] = $userData['email'];

        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($arr);
        } catch(\Exception $e) {
            return $result;
        }

        session_regenerate_id(true);

        $stmt = connect()->prepare("SELECT id FROM users WHERE name = :name");

        $stmt->bindValue('name', $userData['name'], \PDO::PARAM_INT);

        $stmt->execute();

        $id = $stmt->fetch(PDO::FETCH_COLUMN);

        $_SESSION['login_user'] = ['id' => $id, 'name' => $userData['name']];

        return $result;

    }
}
