
<?php


define('DSN', 'mysql:host=localhost;dbname=test;charset=utf8mb4');

define('DB_USER', 'root');
define('DB_PASS', '119089');

// define('DB_USER', 'test');
// define('DB_PASS', '119089Meisei/');

define("dir1", "App/");
define("dir2", "Register/");
define("dir3", "Auth/");
define("dir4", "thread/");

define("userRegisterFormPage", "member_regist.php");

define("userRegisterConfirmPage", "register_confirm_blade.php");

define("userRegisterCompletePage", "register_complete_blade.php");

// ----------------

define("loginPage", "login_blade.php");


define("login_check", "login_check.php");

define("logout", "logout.php");

// -----------------

define("topPage", "top_blade.php");

// -----------------

define("threadListPage", "thread.php");

define("threadRegisterFormPage", "thread_regist.php");

define("threadRegisterConfirmPage", "thread_confirm_blade.php");

define("threadCreate", "thread_create.php")

?>
