<?
include_once('../../library/sql_post.php');
$list		=$_POST['list'];


foreach($list as $a1 => $a2){
	$n++;
	$tmp=explode("_",$a2);

	$sql="UPDATE `wp01_0check_list` SET";
	$sql.=" list_sort='{$n}'";
	$sql.=" WHERE id={$tmp[2]}";
	mysqli_query($mysqli,$sql);
}
exit();
?>
