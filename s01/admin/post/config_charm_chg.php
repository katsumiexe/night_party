<?
include_once('../../library/sql_post.php');
$id		=$_POST['id'];
$val	=$_POST['val'];

$tmp=explode('-',$id);

$sql=" UPDATE wp01_0charm_table SET";
$sql.=" {$tmp[0]}='{$val}'";
$sql.=" WHERE id='{$tmp[1]}'";

mysqli_query($mysqli,$sql);
echo $sql;
exit();
?>
