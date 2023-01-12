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

    public function createUser(array $userData)
    {
        // $result = false; 
        $sql = 'INSERT INTO members (name_sei, name_mei, gender, pref_name, address, password, email) VALUES (?, ?, ?, ?, ?, ?, ?)';

        $arr = [];

        $arr[] = $userData['last_name'];
        $arr[] = $userData['first_name'];
        $arr[] = $userData['sex'];
        $arr[] = $userData['prefecture'];
        $arr[] = isset($_Post['other_address']) ? $userData['other_address'] : null;
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

    /**
     * ログインしているか判定
     * 
     * @param bool $return_flg
     * $return_flgがtrueの場合、ログインしていなければ、
     * メソッドはfalseを返す
     * （ログインユーザ、ゲスト共用ページで用いる）
     * 
     * 引数に何も指定しない場合（falseの場合）、
     * ログインしていなければ、
     * exit()で処理を中断させる。
     * ログインユーザ専用ページで用いる
     * （ゲストユーザがログイン専用ページにアクセスしたとき弾く）
     * 
     * @return bool $login_flg
     * true:ログインユーザ
     */
    public static function checkAuthenticated($return_flg = false)
    {

        // ログインをしている場合、ログイン情報を格納。
        // ログインをしていない場合はnull
        $user_info = isset($_SESSION['login_user']) ? (array) $_SESSION['login_user'] : null;

        /**
         * @var bool
         * ログインしているかを表す。
         * false: ログインしていない
         * true: ログインしている
         */
        // $login_flg = false;

        // ログインしているユーザでトップ画面に入った場合
        if (!is_null($user_info))
        {
            return true;
        }

        if ($return_flg)
        {
            return false;
        }

        exit("ログインしていない場合はアクセスできません。");
        
    }

    /**
     * 
     */
    public function logout()
    {
        $_SESSION = array();
    }
}
