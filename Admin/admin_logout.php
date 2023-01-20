<?php

session_start();
require_once(__DIR__ . '/../config.php');

use App\adminLogic;

if (!$logout = filter_input(INPUT_POST, 'logout'))
{
    exit('不正なリクエストです。');
}

$_SESSION = array();

header('Location:' . adminLoginPage);
