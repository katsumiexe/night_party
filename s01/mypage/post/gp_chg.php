<?
include_once('../../library/sql_post.php');
$name		=$_POST["name"];
$id			=$_POST["id"];

$sql =" UPDATE wp00000_customer_group SET";
$sql.=" tag='{$name}'";
$sql.=" WHERE id='{$id}'";
mysqli_query($mysqli,$sql);
echo $sql;
exit();
?>
