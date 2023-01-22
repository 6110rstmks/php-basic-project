
<?php

define('DSN', 'mysql:host=localhost;dbname=test;charset=utf8mb4');

define('DB_USER', 'root');
define('DB_PASS', '119089');

//---------------------------

spl_autoload_register(function ($class) {

    $class = trim($class, "App\\");

    // windowsかunixかにより絶対パスの指定方法が異なるのでローカルをwindowsで本番をlinuxに
    // すると本番障害がおきる。
    if (PHP_OS == 'WINNT')
    {
        $windows_fileName = sprintf(__DIR__ . '\App\%s.php', $class);

        if (file_exists($windows_fileName))
        {
            require($windows_fileName);
    
        } else {
            echo 'File not found' . $windows_fileName;
            exit;
        }
    } else {

        $unix_fileName = sprintf(__DIR__ . '/App/%s.php', $class);

        $_SESSION['path'] = $unix_fileName;

        if (file_exists($unix_fileName))
        {
            require($unix_fileName);
    
        } else {
            echo 'File not found' . $unix_fileName;
            exit;
        }
    }
});


define("dir1", "App/");
define("dir2", "Register/");
define("dir3", "Auth/");
define("dir4", "thread/");

define("dir5", "comment/");
define("dir6", "like/");
define("dir7", "Admin/");

define("MemberLogic","MemberLogic.php");
define("ThreadLogic","ThreadLogic.php");


// ---------------------------

define("memberRegisterFormPage", "member_regist_blade.php");

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

define("threadCreate", "thread_create.php");

define("threadDetail", "thread_detail.php");

//-----------------------

define("commentSave", "comment_save.php");

// ----------------------

define("likeToggle", "like_toggle.php");

// ----------------------

define("adminLoginPage", "admin_login_blade.php");

define("adminLoginCheck", "admin_login_check.php");

define("adminTopPage", 'admin_top_blade.php');

define("adminLogout", 'admin_logout.php');

define("memberList", 'member_list.php');

define("withdrawalConfirmPage", "withdrawal_confirm_blade.php");

?>
