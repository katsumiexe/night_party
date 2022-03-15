<?
/*
Icon_Table_Del 
*/

include_once('../../library/sql_post.php');
include_once("../../library/inc_code.php");

$list_id	=$_POST["list_id"];
$sort=1;

$sql ="SELECT * FROM wp00000_cast_log_table"; 
$sql.=" WHERE cast_id='{$cast_data["id"]}'"; 
$sql.=" ORDER BY `sort` ASC"; 

if($result = mysqli_query($mysqli,$sql)){

	while($row = mysqli_fetch_assoc($result)){
		if($row["id"] !=$list_id){
			$sql=" UPDATE wp00000_cast_log_table SET";
			$sql.=" `sort`='{$sort}'"; 
			$sql.=" WHERE `id`='{$row["id"]}'"; 
			mysqli_query($mysqli,$sql);
			$sort++;

		}else{
			$sql ="DELETE FROM wp00000_cast_log_table"; 
			$sql.=" WHERE `id`='{$list_id}'"; 
			mysqli_query($mysqli,$sql);
		}
	}
}
exit();
?>
