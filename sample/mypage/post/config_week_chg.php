<?
include_once('../../library/sql_post.php');
$week		=$_POST["week"];
$sql =" UPDATE wp00000_cast SET";
$sql.=" week_st='{$week}'";
$sql.=" WHERE id='{$cast_data["id"]}'";
mysqli_query($mysqli,$sql)
exit();
?>
