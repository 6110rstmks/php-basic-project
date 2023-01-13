<?php

/**
 * 引数で受け取ったセッションキーがあるか確認し、
 * セッションキーに対応する値を削除
 * 返り値として戻すために一時的にセッションキーに対応する値を変数に格納し
 * なければnullを返す
 * 
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