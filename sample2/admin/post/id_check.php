<?
include_once('../../library/sql_post_admin.php');

$id		=$_POST['id'];
$set	=$_POST['set'];

$sql	 ="SELECT id FROM ".TABLE_KEY."_cast";
$sql	.=" WHERE login_id='{$id}'";
$sql	.=" AND cast_status<'5'";
if($set){
$sql	.=" AND id<>{$set}'";
}
$sql	.=" LIMIT 1";

$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);
if($row["id"] > 0){
	echo "err";
}

exit();
?>

