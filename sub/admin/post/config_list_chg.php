<?
include_once('../../library/sql_post.php');
$id		=$_POST['id'];
$val	=$_POST['val']+0;


if(substr($id,0,5)=='tr_n_'){
	$id=str_replace('tr_n_','',$id);
	$app ="UPDATE `".TABLE_KEY."_tag` SET";
	$app.=" del='{$val}'";
	$app.=" WHERE id='{$id}'";

}elseif(substr($id,0,5)=='tr_p_'){
	$id=str_replace('tr_p_','',$id);
	$app ="UPDATE `".TABLE_KEY."_charm_table` SET";
	$app.=" del='{$val}'";
	$app.=" WHERE id='{$id}'";
}
echo $app;
mysqli_query($mysqli,$app);
exit();
?>
