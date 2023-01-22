<?php

/**
 * 引数で受け取ったセッションキーがあるか確認し、
 * セッションキーに対応する値を削除
 * 返り値として戻すために一時的にセッションキーに対応する値を変数に格納し
 * なければnullを返す
 * 
 * 登録フォームなどでバリデーションに引っかかり登録フォームにリダイレクトさせられたときに
 * 入力したデータを保持する
 */
function FormValueRetention($var_name)
{
    if (isset($_SESSION[$var_name]))
    {
        $session_value = $_SESSION[$var_name];
        unset($_SESSION[$var_name]);
        return $session_value;
    }

    return null;
}

/**
 * sql文を作成してそれを返す
 * member_list.phpで使用するかも
 * ぼつ
 * @param 
 * @return string $sql
 */
function createQuery(...$column)
{
    // $sql = ""
}

function addOrderQuery($order_flg)
{

}