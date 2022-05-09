<?
include_once('../../library/sql_post_admin.php');

$key		=$_POST["key"];
$value		=$_POST["value"];
$tmp=explode("_", $key);

$a1=trim($tmp[1]);
$a2=trim($tmp[2]);

if($tmp[0] == "ttl"){
	$sql="UPDATE `".TABLE_KEY."_check_main` SET";
	$sql.=" title='{$value}'";
	$sql.=" WHERE id='{$a1}'";
	mysqli_query($mysqli,$sql);

}elseif($tmp[0] == "sel"){
	$sql="UPDATE `".TABLE_KEY."_check_main` SET";
	$sql.=" style='{$value}'";
	$sql.=" WHERE id='{$a1}'";
	mysqli_query($mysqli,$sql);

}elseif($tmp[0] == "itm"){

	$sql="SELECT id FROM `".TABLE_KEY."_check_list`";
	$sql.=" WHERE host_id='{$a1}'";
	$sql.=" AND list_sort='{$a2}'";
	mysqli_query($mysqli,$sql);
	$result = mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_assoc($result);

	if($row["id"]){	
		$sql="UPDATE `".TABLE_KEY."_check_list` SET";
		$sql.=" list_title='{$value}'";
		$sql.=" WHERE host_id='{$a1}'";
		$sql.=" AND id='{$a2}'";

	}else{
		$sql="INSERT INTO `".TABLE_KEY."_check_list` (`host_id`,`list_sort`,`list_title`,`del`)";
		$sql.=" VALUES('{$a1}','{$a2}','{$value}','0')";

	}
	mysqli_query($mysqli,$sql);
	echo $sql;

}elseif($tmp[0] == "new"){
	$sql="INSERT INTO  `".TABLE_KEY."_check_list`(`host_id`,`list_sort`,`list_title`,`del`)";
	$sql.=" VALUES('{$a1}','{$a2}','{$value}','0')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);
	echo "itm_".$a1."_".$tmp_auto;
}
exit();
?>
