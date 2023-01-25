<?php

session_start();

require_once(__DIR__ . '/../config.php');


$sql = 'SELECT * FROM members WHERE true';

// 検索idの指定がある場合
if (!empty($_POST['id']))
{
    $sql .= " AND id = :id";
}

// 検索フォームにて男性のみの指定がある場合
if (isset($_POST['male']) && !isset($_POST['female']))
{
    $sql .= " AND gender = 0";
    
} elseif (!isset($_POST['male']) && isset($_POST['female']))
{
    // 女性のみの指定がある場合
    $sql .= " AND gender = 1";


} elseif (isset($_POST['male']) && isset($_POST['female']))
{
    // 男性、女性、両方の指定がある場合
    $sql .= " AND (gender = 1 OR gender = 0)";

}

if (!empty($_POST['prefecture']))
{
    $sql .= " AND pref_name = :pref_name";
}


// 検索フォームにてフリーワードの指定がある場合
if (!empty($_POST['free_word']))
{
    $sql .= " AND (name_sei Like :free_word1 OR name_mei Like :free_word2 OR email LIKE :free_word3)";
}


// 昇順降順のtoggleボタンを押した場合
if (isset($_POST['order_toggle']))
{

    // このif文より上の行で作成した$sqlを破棄して前回に使用したsql文を使用する
    $sql = $_SESSION['temp_sql'];

    // ASCの文字列をsql文の中に持つ場合（ボタンを押す前の順番が昇順の場合）
    if (strpos($sql, "ASC") !== false)
    {
        // sql文からASCを削除してDESCに変更
        $sql = str_replace('ASC', 'DESC', $sql);

    } elseif (strpos($sql, "DESC") !== false)
    {
        $sql = str_replace('DESC', 'ASC', $sql);   
    }
} else {
    $sql .= " ORDER BY id DESC";
}

// member_list2.phpで使うためのsql文

$_SESSION['from_search_sql'] = $sql;

if (!isset($_POST['order_toggle']))
{

    $_SESSION['search_post'] = $_POST;
}

// メンバ数の取得はmember_list2.phpで行う

header('Location:' . memberList);