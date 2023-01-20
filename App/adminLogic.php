<?php

namespace App;

class adminLogic {

    private $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($login_id, $password)
    {

        $sql = 'SELECT * FROM administers WHERE login_id = :login_id and password = :password';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':login_id', $login_id);
        $stmt->bindValue(':password', $password);

        $stmt->execute();
        $admin = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($admin != false)
        {
            $_SESSION['login_admin'] = $admin;
        }

        return $admin;

    }

    public static function checkAuthenticated()
    {
        $admin_info = isset($_SESSION['login_admin']) ? (array) $_SESSION['login_admin'] : null;

        // ログインしているユーザでトップ画面に入った場合
        if (!is_null($admin_info))
        {
            return true;
        }

        // if ($return_flg)
        // {
        //     return false;
        // }

        // $return_flgがfalseでかつログインしていなければ以下の文を表示

        exit("ログインしていない場合はアクセスできません。");
    }


}