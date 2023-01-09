<?php

ini_set('display_error', true);

define('DSN', 'mysql:host=localhost;dbname=test;charset=utf8mb4');
define('DB_USER', 'test');
define('DB_PASS', '119089Meisei/');

function connect()
{
  try
  {
    $pdo = new PDO(
      DSN,
      DB_USER,
      DB_PASS,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]
    );
    return $pdo;

  } catch(PDOException $e) {
    echo $e -> getMessage();
    exit();
  }
}


?>