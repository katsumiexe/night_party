<?
include_once('../../library/sql_post.php');
	$id		=$_POST['id'];
	$log	=$_POST['log'];
	$staff	=$_POST['staff'];
	$radio	=$_POST['radio'];

	$app ="UPDATE `wp01_0contact_list` SET";
	$app.=" res_log='{$log}',";
	$app.=" res_radio='{$radio}',";
	$app.=" staff='{$staff}',";
	$app.=" res_date='{$now}'";
	$app.=" WHERE list_id='{$id}'";

echo $app;

mysqli_query($mysqli,$app);
exit();
?>
