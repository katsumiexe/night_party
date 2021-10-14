<?
/*
メモ削除
*/

include_once('../library/sql_post.php');
$memo_id	=$_POST["memo_id"];

$sql ="UPDATE wp00000_customer_memo SET";
$sql.=" `del`='1'";
$sql.=" WHERE id='{$memo_id}'";
mysqli_query($mysqli,$sql);

exit();
?>
