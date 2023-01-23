<?php

namespace App;

class MemberLogic {

    private $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * thread_detail.phpで使用
     */
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
     * register_confirm_blade.phpにて使用
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

        $member = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $member;
    }

    /**
     * 
     * @param array $memberData
     * 
     */
    public function createMember(array $memberData)
    {
        $sql = 'INSERT INTO members (name_sei, name_mei, gender, pref_name, address, password, email, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, now())';

        $arr = [];

        $arr[] = $memberData['last_name'];
        $arr[] = $memberData['first_name'];
        $arr[] = $memberData['sex'];
        $arr[] = $memberData['prefecture'];
        $arr[] = isset($memberData['other_address']) ? $memberData['other_address'] : null;
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
     * @return array $member
     * 
     */
    public function login($email, $password)
    {
        $sql = 'SELECT * FROM members WHERE email = :email and password = :password';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);

        $stmt->execute();
        $member = $stmt->fetchAll(\PDO::FETCH_ASSOC);

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

        // ログインしているユーザでトップ画面に入った場合
        if (!is_null($member_info))
        {
            return true;
        }

        if ($return_flg)
        {
            return false;
        }

        // $return_flgがfalseでかつログインしていなければ以下の文を表示

        exit("ログインしていない場合はアクセスできません。");
        
    }

    /**
     * member_list.phpで使用
     */
    public function getAllMembers()
    {
        $sql = "SELECT * FROM members order by id DESC";
        $stmt = $this->pdo->query($sql);
        $members = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $members;
    }

    public function softDelete($member_id)
    {
        $sql = "UPDATE members SET deleted_at = now() WHERE id = :member_id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':member_id', $member_id);
        
        $stmt->execute();
    }

    /**
     * member_list.phpで使用,getMemberByIDと処理が同じです。
     * @param string $sql, bool $asc_flg
     */
    public function searchMember($sql, $asc_flg = false)
    {
        if ($asc_flg)
        {
            $order_sql = 'order by id ASC';

            $pdo->prepare($sql . $order_sql);
            $pdo->execute();
        }

    }

    public function searchMemberById($id)
    {
        $sql = 'SELECT * FROM members WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        // $member = $stmt-;
    }

    /**
     * 
     */
    public function logout()
    {
        $_SESSION = array();
    }
}
