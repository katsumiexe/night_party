<?
/*
mail_hist
*/
include_once('../library/sql.php');

$ss			=$_POST['ss'];
$ck			=$_POST['ck'];

$sql	 ="SELECT cast_id,customer_id FROM wp00000_ssid";
$sql	.=" WHERE ssid='{$ss}'";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$dat = mysqli_fetch_assoc($result);
}


$sql	 ="UPDATE wp00000_customer SET";
$sql	.=" opt='{$ck}'";
$sql	.=" WHERE cast_id='{$dat["cast_id"]}'";
$sql	.=" AND id='{$dat["customer_id"]}'";
mysqli_query($mysqli,$sql);
echo $sql;
exit();
?>
