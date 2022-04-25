<?
include_once('../../library/sql_post.php');
$id		=$_POST['id'];

$sql	 ="SELECT id FROM ".TABLE_KEY."_contact_table";
$sql	.=" WHERE del=0 OR del IS NULL";
$sql	.=" ORDER BY sort ASC";
echo $sql."/";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["id"] == $id){
			$sql	 ="UPDATE ".TABLE_KEY."_contact_table SET";
			$sql	.=" del='1'";
			$sql	.=" WHERE id='{$row["id"]}'";
			mysqli_query($mysqli,$sql);
		}else{
			$sort++;
			$sql	 ="UPDATE ".TABLE_KEY."_contact_table SET";
			$sql	.=" sort='{$sort}'";
			$sql	.=" WHERE id='{$row["id"]}'";
			mysqli_query($mysqli,$sql);
		}

echo $sql."/";

	}
}
exit();
?>
