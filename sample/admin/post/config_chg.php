<?
include_once('../../library/sql_post.php');
$id		=$_POST['id'];
$val	=$_POST['val'];



if(substr($id,0,5) == "schen"){
	$tmp=substr($id,6);
	$sql	 ="UPDATE `wp00000_sch_table` SET";
	$sql	.=" name='{$val}'";
	$sql	.=" WHERE id='{$tmp}'";

}elseif(substr($id,0,5) == "schet"){
	$tmp	 =substr($id,6);
	$sql	 ="UPDATE `wp00000_sch_table` SET";
	$sql	.=" time='{$val}'";
	$sql	.=" WHERE id='{$tmp}'";


}else{
	$app ="UPDATE `wp00000_config` SET";
	$app.=" config_value='{$val}'";
	$app.=" WHERE config_key='{$id}'";
}



mysqli_query($mysqli,$app);
exit();
?>
