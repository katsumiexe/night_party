<?
include_once('../../library/sql_post.php');

$id		=$_POST['id'];
$dat	=$_POST['dat'];

if(strpos("-".$id,"rec_")>0){
	$id=str_replace("rec_","",$id);

	$sql	 ="SELECT id,contents_key FROM wp00000_contents";
	$sql	.=" WHERE page='recruit'";
	$sql	.=" AND `category`='{$id}'";
	$sql	.=" LIMIT 1";
	$result = mysqli_query($mysqli,$sql);
	$res = mysqli_fetch_assoc($result);


	if(!$res["contents_key"]){
		$sql	 ="INSERT INTO wp00000_contents(`page`, `category`, `contents_key`,`status`)";
		$sql	.=" VALUES('recruit','{$id}','{$dat}','0')";

	}else{
		$sql	 ="UPDATE wp00000_contents SET";
		$sql	.=" `contents_key`='{$dat}'";
		$sql	.=" WHERE id='{$res["id"]}'";
	}
	mysqli_query($mysqli,$sql);

}elseif(strpos("-".$id,"name")>0){
	$id=str_replace("name","",$id);
	$sql	 ="UPDATE wp00000_contact_table SET";
	$sql	.=" log_{$id}_name='{$dat}'";
	$sql	.=" WHERE id='1'";
	mysqli_query($mysqli,$sql);


}elseif(strpos("-".$id,"type")>0){
	$id=str_replace("type","",$id);

	$sql	 ="SELECT log_{$id}_type FROM wp00000_contact_table";
	$sql	.=" LIMIT 1";
	$result = mysqli_query($mysqli,$sql);
	$res = mysqli_fetch_assoc($result);
	$tmp=$dat.substr($res["log_{$id}_type"],-1,1);

	$sql	 ="UPDATE wp00000_contact_table SET";
	$sql	.=" log_{$id}_type='{$tmp}'";
	$sql	.=" WHERE id='1'";
	mysqli_query($mysqli,$sql);


}elseif(strpos("-".$id,"chg")>0){
	$id=str_replace("chg","",$id);

	$sql	 ="SELECT log_{$id}_type FROM wp00000_contact_table";
	$sql	.=" LIMIT 1";

	$result = mysqli_query($mysqli,$sql);
	$res = mysqli_fetch_assoc($result);
	$tmp=substr($res["log_{$id}_type"],0,1)*10+$dat;

	$sql	 ="UPDATE wp00000_contact_table SET";
	$sql	.=" log_{$id}_type='{$tmp}'";
	$sql	.=" WHERE id='1'";
	mysqli_query($mysqli,$sql);
}

exit();
?>
