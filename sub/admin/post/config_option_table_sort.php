<?
include_once('../../library/sql_post.php');
$list		=$_POST['list'];


foreach($list as $a2){
	$n++;
	$tmp=str_replace("tbl","",$a2);

	$sql="UPDATE `".TABLE_KEY."_check_main` SET";
	$sql.=" sort='{$n}'";
	$sql.=" WHERE id={$tmp}";
	mysqli_query($mysqli,$sql);
}
echo $sql;

exit();

?>
