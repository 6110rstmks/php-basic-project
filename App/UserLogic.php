<?php

namespace App;


class UserLogic {

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
    public function checkSameDataExist($column, $data)
    {
        $sql = 'SELECT * FROM members WHERE :column = :data';
        

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':column', $column);
        $stmt->bindValue(':data', $data);

        $stmt->execute();

        $user = $stmt->fetch();

        return $user;
    }

    public function createUser(array $userData)
    {
        // $result = false; 
        $sql = 'INSERT INTO members (name_sei, name_mei, gender, pref_name, address, password, email) VALUES (?, ?, ?, ?, ?, ?, ?)';

        $arr = [];

        $arr[] = $userData['last_name'];
        $arr[] = $userData['first_name'];
        $arr[] = $userData['sex'];
        $arr[] = $userData['prefecture'];
        $arr[] = $userData['other_address'];
        $arr[] = $userData['password'];
        $arr[] = $userData['email'];

        // $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($arr);




        // session_regenerate_id(true);

        // $stmt = connect()->prepare("SELECT id FROM users WHERE name = :name");

        // $stmt->bindValue('name', $userData['name'], \PDO::PARAM_INT);

        // $stmt->execute();

        // $id = $stmt->fetch(PDO::FETCH_COLUMN);

        // $_SESSION['login_user'] = ['id' => $id, 'name' => $userData['name']];

        // return $result;

    }

    /**
     * 
     * @param string $email, $password
     * @return array|bool $member
     */
    public function login($email, $password)
    {
        $sql = 'SELECT * FROM members WHERE email = :email and password = :password';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);

        // $result = $stmt->execute();
        $stmt->execute();
        $member = $stmt->fetch();

        return $member;

    }

    public function getNameByEmail($email)
    {

    }

    public function checkAuthenticated()
    {

    }
}
