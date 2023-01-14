
<?php


define('DSN', 'mysql:host=localhost;dbname=test;charset=utf8mb4');

define('DB_USER', 'root');
define('DB_PASS', '119089');

// define('DB_USER', 'test');
// define('DB_PASS', '119089Meisei/');

//---------------------------

spl_autoload_register(function ($class) {
    
    $prefix = 'App';

    if (strpos($class, $prefix) === 0)
    {
        // $fileName = sprintf(__DIR__ . '/%s.php', substr($class, strlen($prefix)));
        $fileName = sprintf(__DIR__ . '\%s.php', $class);
    }

    if (file_exists($fileName))
    {
        require($fileName);

    } else {
        echo 'File not found' . $fileName;
        exit;
    }

});


define("dir1", "App/");
define("dir2", "Register/");
define("dir3", "Auth/");
define("dir4", "thread/");

define("MemberLogic","MemberLogic.php");
define("ThreadLogic","ThreadLogic.php");


// ---------------------------

define("memberRegisterFormPage", "member_regist.php");

define("memberRegisterConfirmPage", "register_confirm_blade.php");

define("memberRegisterCompletePage", "register_complete_blade.php");

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
