<?
include_once('../../library/sql_post.php');
$id		=$_POST['id'];
$val	=$_POST['val'];

	$app ="UPDATE `wp00000_config` SET";
	$app.=" config_value='{$val}'";
	$app.=" WHERE config_key='{$id}'";
echo $app;

mysqli_query($mysqli,$app);
exit();
?>
