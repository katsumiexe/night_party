<?
include_once('../../library/sql_post_admin.php');

$id		=$_POST['id'];
$val	=$_POST['val'];
if(substr($id,0,5) == "schen"){
	$tmp=substr($id,6);
	$sql	 ="UPDATE `".TABLE_KEY."_sch_table` SET";
	$sql	.=" name='{$val}'";
	$sql	.=" WHERE id='{$tmp}'";

}elseif(substr($id,0,5) == "schet"){
	$tmp	 =substr($id,6);
	$sql	 ="UPDATE `".TABLE_KEY."_sch_table` SET";
	$sql	.=" time='{$val}'";
	$sql	.=" WHERE id='{$tmp}'";


}else{
	$app ="UPDATE `".TABLE_KEY."_config` SET";
	$app.=" config_value='{$val}'";
	$app.=" WHERE config_key='{$id}'";
}



mysqli_query($mysqli,$app);
exit();
?>
