<?php
require_once(__DIR__ . '/../config.php');

use App\Database;
use App\MemberLogic;

$member_id = $_GET['id'];

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo);

$memberLogic->softDelete($member_id);

header('Location:' . memberList);

?>
