<?
include_once('../library/sql.php');

$ss			=$_POST['ss'];
$ck			=$_POST['ck'];

$sql	 ="SELECT cast_id,customer_id FROM ".TABLE_KEY."_ssid";
$sql	.=" WHERE ssid='{$ss}'";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$dat = mysqli_fetch_assoc($result);
}


$sql	 ="UPDATE ".TABLE_KEY."_customer SET";
$sql	.=" opt='{$ck}'";
$sql	.=" WHERE cast_id='{$dat["cast_id"]}'";
$sql	.=" AND id='{$dat["customer_id"]}'";
mysqli_query($mysqli,$sql);
echo $sql;
exit();
?>
