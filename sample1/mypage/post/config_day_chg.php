<?
include_once('../../library/sql_post.php');
$times		=$_POST["times"]+0;

$sql =" UPDATE ".TABLE_KEY."_cast SET";
$sql.=" times_st='{$times}'";
$sql.=" WHERE id='{$cast_data["id"]}'";
//mysqli_query($mysqli,$sql);
exit();
?>
