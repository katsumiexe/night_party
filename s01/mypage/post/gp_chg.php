<?
include_once('../../library/sql_post.php');
$name		=$_POST["name"];
$id			=$_POST["id"];

$sql =" UPDATE wp01_0customer_group SET";
$sql.=" tag='{$name}'";
$sql.=" WHERE id='{$id}'";
mysqli_query($mysqli,$sql);
echo $sql;
exit();
?>
