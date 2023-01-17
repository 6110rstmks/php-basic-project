<?php

namespace App;

class MemberLogic {

    private $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getMemberById($id)
    {
        $sql = 'SELECT * FROM members Where id = :id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        $member = $stmt->fetchObject();

        return $member;
    }

    /**
     * 
     * @param string $email
     * @return bool
     * 
     */

    public function checkEmailExist($data)
    {
        $sql = 'SELECT * FROM members WHERE email = :data';

        $stmt = $this->pdo->prepare($sql);

        // $stmt->execute();
        $stmt->execute(array(
            ':data' => $data,
        ));

        $member = $stmt->fetchAll();

        return $member;
    }

    /**
     * 
     * @param array $memberData
     * 
     */
    public function createMember(array $memberData)
    {
        // $result = false; 
        $sql = 'INSERT INTO members (name_sei, name_mei, gender, pref_name, address, password, email) VALUES (?, ?, ?, ?, ?, ?, ?)';

        $arr = [];

        $arr[] = $memberData['last_name'];
        $arr[] = $memberData['first_name'];
        $arr[] = $memberData['sex'];
        $arr[] = $memberData['prefecture'];
        $arr[] = isset($_Post['other_address']) ? $memberData['other_address'] : null;
        $arr[] = $memberData['password'];
        $arr[] = $memberData['email'];

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($arr);

        // session_regenerate_id(true);

        // $stmt = connect()->prepare("SELECT id FROM Members WHERE name = :name");

        // $stmt->bindValue('name', $MemberData['name'], \PDO::PARAM_INT);

        // $stmt->execute();

        // $id = $stmt->fetch(PDO::FETCH_COLUMN);

        // $_SESSION['login_Member'] = ['id' => $id, 'name' => $MemberData['name']];

        // return $result;

    }

    /**
     * ログイン
     * @param string $email, $password
     * @return array|bool $member
     * 
     */
    public function login($email, $password)
    {
        $sql = 'SELECT * FROM members WHERE email = :email and password = :password';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);

        $stmt->execute();
        $member = $stmt->fetchObject();

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
        $member_info = isset($_SESSION['login_member']) ? (array) $_SESSION['login_member'] : null;

        /**
         * @var bool
         * ログインしているかを表す。
         * false: ログインしていない
         * true: ログインしている
         */
        // $login_flg = false;

        // ログインしているユーザでトップ画面に入った場合
        if (!is_null($member_info))
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
