<?php

namespace App;

class MemberLogic {

    private $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * thread_detail.php, member_confirm_blade.phpで使用
     */
    public function getMemberById($id)
    {
        $sql = 'SELECT * FROM members Where id = :id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        // $member = $stmt->fetchObject();
        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $member;
    }

    /**
     * 
     * member_confirm_blade.phpにて使用
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
     * member_confirm_blade.phpで使用
     */
    public function checkEmailExistEditVer($data)
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
    }

    /**
     * 
     * member_complete_blade.phpで使用
     * @param array $memberData
     * @return 
     */
    public function updateMember($memberData)
    {
        $id = intval($memberData['id']);

        if (!isset($memberData['password']))
        {
            $sql = 'UPDATE members SET name_sei = :name_sei, name_mei = :name_mei, gender = :gender, pref_name = :pref_name, address = :address, email = :email, updated_at = now() WHERE id = :id';
        } else {
            $sql = 'UPDATE members SET name_sei = :name_sei, name_mei = :name_mei, gender = :gender, pref_name = :pref_name, address = :address, password = :password, email = :email, updated_at = now() WHERE id = :id';
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name_sei', $memberData['last_name']);
        $stmt->bindValue(':name_mei', $memberData['first_name']);
        $stmt->bindValue(':gender', $memberData['sex']);
        $stmt->bindValue(':pref_name', $memberData['prefecture']);
        $stmt->bindValue(':address', $memberData['other_address']);
        $stmt->bindValue(':email', $memberData['email']);
        if (isset($memberData['password']))
        {
            $stmt->bindValue(':password', $memberData['password']);
        }

        $stmt->execute();
    }

    /**
     * そのメンバを返すことでログインする。
     * 関数の呼び出し側で戻り値をうけとりそれをsessionに格納
     * 
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
     * member_list.phpで使用→今は使ってない
     */
    public function getAllMembers()
    {
        $sql = "SELECT * FROM members order by id DESC";
        $stmt = $this->pdo->query($sql);
        $members = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $members;
    }

    /**
     * 
     * 
     */
    public function softDelete($member_id)
    {
        $sql = "UPDATE members SET deleted_at = now() WHERE id = :member_id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':member_id', $member_id);
        
        $stmt->execute();
    }

    /**
     * 
     * member_list.phpで使用
     * @return int 
     */
    public function CountSearchMember($sql, $_post)
    {
        $stmt = $this->pdo->prepare($sql);

        // 検索フォームでidを指定した場合
        if (!empty($_post['id']))
        {
            $stmt->bindValue(':id', $_post['id']);
        }

        if (!empty($_post['prefecture']))
        {
            $stmt->bindValue(':pref_name', $_post['prefecture']);
        }

        if (!empty($_post['free_word']))
        {
            $pattern = '%' . $_post['free_word'] . '%'; 

            $stmt->bindValue(':free_word1', $pattern);
            $stmt->bindValue(':free_word2', $pattern);
            $stmt->bindValue(':free_word3', $pattern);
        }

        $stmt->execute();

        // $cnt = $stmt->fetchColumn();
        $cnt = $stmt->rowCount();

        return $cnt;
    }

    /**
     * member_list.phpで使用
     * @param string $sql, array $_post
     */
    public function searchMember($sql, $_post, $offset)
    {

        $stmt = $this->pdo->prepare($sql);

        // 検索フォームでidを指定した場合
        if (!empty($_post['id']))
        {
            $stmt->bindValue(':id', $_post['id']);
        }

        if (!empty($_post['prefecture']))
        {
            $stmt->bindValue(':pref_name', $_post['prefecture']);
        }

        if (!empty($_post['free_word']))
        {
            $pattern = '%' . $_post['free_word'] . '%'; 

            $stmt->bindValue(':free_word1', $pattern);
            $stmt->bindValue(':free_word2', $pattern);
            $stmt->bindValue(':free_word3', $pattern);
        }

        $stmt->bindValue(':offset', $offset);

        $stmt->execute();

        $members = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $members;
    }


    public function searchMemberById($id)
    {
        $sql = 'SELECT * FROM members WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

    }

    /**
     * メンバの総数を取得
     */
    public function CountMembers()
    {
        $sql = 'SELECT count(*) FROM members WHERE thread_id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $thread_id);
        $stmt->execute();

        $cnt = $stmt->fetchColumn();

        return $cnt;
    }
}
