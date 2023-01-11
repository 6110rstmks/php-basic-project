// 保守性を高めURLを自動で生成するパターン
header('Location:https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/confirm.php');