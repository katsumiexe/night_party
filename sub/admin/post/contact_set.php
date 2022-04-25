<?
include_once('../../library/sql_post.php');
	$id		=$_POST['id'];
	$log	=$_POST['log'];
	$staff	=$_POST['staff'];
	$radio	=$_POST['radio'];

	$app ="UPDATE `".TABLE_KEY."_contact_list` SET";
	$app.=" log='{$log}',";
	$app.=" res_kind='{$radio}',";
	$app.=" staff='{$staff}',";
	$app.=" send_date='{$now}'";
	$app.=" WHERE list_id='{$id}'";

echo $app;

mysqli_query($mysqli,$app);
exit();
?>
