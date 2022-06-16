<?
include_once('../../library/sql_post_admin.php');
$id		=$_POST['id'];
$val	=$_POST['val'];

$tmp=explode('-',$id);

$sql=" UPDATE ".TABLE_KEY."_tag SET";
$sql.=" {$tmp[0]}='{$val}'";
$sql.=" WHERE id='{$tmp[1]}'";

mysqli_query($mysqli,$sql);
echo $sql;
exit();
?>
