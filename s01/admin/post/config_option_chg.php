<?
include_once('../../library/sql_post_admin.php');

$key		=$_POST["key"];
$value		=$_POST["value"];

$tmp=explode("_", $key);

$a1=trim($tmp[1]);
$a2=trim($tmp[2]);

if($tmp[0] == "ttl"){
	$sql="UPDATE `wp00000_check_main` SET";
	$sql.=" title='{$value}'";
	$sql.=" WHERE id='{$a1}'";
	mysqli_query($mysqli,$sql);

}elseif($tmp[0] == "sel"){
	$sql="UPDATE `wp00000_check_main` SET";
	$sql.=" style='{$value}'";
	$sql.=" WHERE id='{$a1}'";
	mysqli_query($mysqli,$sql);

}elseif($tmp[0] == "itm"){
	$sql="UPDATE `wp00000_check_list` SET";
	$sql.=" list_title='{$value}'";
	$sql.=" WHERE host_id='{$a1}'";
	$sql.=" AND id='{$a2}'";
	mysqli_query($mysqli,$sql);

}elseif($tmp[0] == "new"){
	$sql="INSERT INTO  `wp00000_check_list`(`host_id`,`list_sort`,`list_title`)";
	$sql.=" VALUES('{$a1}','{$a2}','{$value}')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);
	echo "itm_".$a1."_".$tmp_auto;
}

exit();
?>
