<?
include_once('../../library/sql_post.php');

$no		=$_POST['no'];
$id		=$_POST['id'];
$dat	=$_POST['dat'];

$sql	 ="SELECT id FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE id='{$no}'";
$sql	.=" LIMIT 1";
$result = mysqli_query($mysqli,$sql);
$check = mysqli_fetch_assoc($result);

if(strpos("-".$id,"rec_")>0){
	$id=str_replace("rec_","",$id);
	$sql	 ="SELECT id,contents_key FROM ".TABLE_KEY."_contents";
	$sql	.=" WHERE page='recruit'";
	$sql	.=" AND `category`='{$id}'";
	$sql	.=" LIMIT 1";
	$result = mysqli_query($mysqli,$sql);
	$res = mysqli_fetch_assoc($result);

	if(!$res["contents_key"]){
		$sql	 ="INSERT INTO ".TABLE_KEY."_contents(`page`, `category`, `contents_key`,`status`)";
		$sql	.=" VALUES('recruit','{$id}','{$dat}','0')";

	}else{
		$sql	 ="UPDATE ".TABLE_KEY."_contents SET";
		$sql	.=" `contents_key`='{$dat}'";
		$sql	.=" WHERE id='{$res["id"]}'";
	}
	mysqli_query($mysqli,$sql);

}elseif(strpos("-".$id,"name")>0){
	$id=str_replace("name","",$id);
	$sql	 ="UPDATE ".TABLE_KEY."_contact_table SET";
	$sql	.=" name='{$dat}'";
	$sql	.=" WHERE id='{$id}'";
	mysqli_query($mysqli,$sql);

}elseif(strpos("-".$id,"type")>0){
	$id=str_replace("type","",$id);
	$sql	 ="UPDATE ".TABLE_KEY."_contact_table SET";
	$sql	.=" type='{$dat}'";
	$sql	.=" WHERE id='{$id}'";
	mysqli_query($mysqli,$sql);


}elseif(strpos("-".$id,"chg")>0){
	$id=str_replace("chg","",$id);
	$sql	 ="UPDATE ".TABLE_KEY."_contact_table SET";
	$sql	.=" ck='{$dat}'";
	$sql	.=" WHERE id='{$id}'";
	mysqli_query($mysqli,$sql);
}
exit();
?>
