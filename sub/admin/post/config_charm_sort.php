<?
include_once('../../library/sql_post.php');
$list		=$_POST['list'];

$n=0;
foreach($list as $a2){
	$n++;
	$tmp=str_replace("tr_p_","",$a2);

	$sql="UPDATE `".TABLE_KEY."_tag` SET";
	$sql.=" sort='{$n}'";
	$sql.=" WHERE id={$tmp}";
	mysqli_query($mysqli,$sql);
}
echo $sql;

exit();

?>
