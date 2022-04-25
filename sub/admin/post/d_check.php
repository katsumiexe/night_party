<?
include_once('../../library/sql_post_admin.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$key		=$_POST["key"];
$value		=$_POST["value"];

$status=array("通常","準備","休職","退職","停止");

$item["login_id"]="ログインID";
$item["tel"]="電話番号";
$item["mail"]="メールアドレス";
$item["line"]="ラインID";

$sql	 ="SELECT staff_id, genji, cast_status FROM ".TABLE_KEY."_staff AS S";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE S.del=0";
$sql	.=" and {$key}='{$value}'";
$sql	.=" and (C.cast_status<5 OR C.cast_status IS NULL)";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);

if(!$row["genji"]){
	$row["genji"] = $row["name"];
}

if($row["staff_id"]){
	echo "<div class=\"alert_d_2 d_{$key}\"><span class=\"alert_d_tag\">{$item[$key]}</span>	<span class=\"alert_d_cast\">{$row["staff_id"]}　{$row["genji"]}（{$status[$row["cast_status"]]}）</span><div class=\"alert_d_al\"></div></div>";
}

exit();
?>
