<?
include_once('../../library/sql_post.php');
$list		=$_POST["list"];

foreach($list as $a1 => $a2){
	$b1=str_replace("gp","",$a2);
	$b2++;
	
	$sql =" UPDATE wp00000_customer_group SET";
	$sql.=" sort='{$b2}'";
	$sql.=" WHERE id='{$b1}'";
	mysqli_query($mysqli,$sql);
}

echo $sql;
exit();
?>
