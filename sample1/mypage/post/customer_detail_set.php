<?
/*
■顧客情報更新　
　名前
　ニックネーム
　グループ
*/

include_once('../../library/sql_post.php');
$c_id	=$_POST["c_id"];
$id		=$_POST["id"];
$param	=$_POST["param"];

if($id == "customer_group"){
	$app=" c_group='{$param}'";

}elseif($id == "customer_detail_name"){
	$app=" `name`='{$param}'";

}elseif($id == "customer_detail_nick"){
	$app=" `nickname`='{$param}'";
}

$sql ="UPDATE ".TABLE_KEY."_customer SET";
$sql.=$app;
$sql.=" WHERE id={$c_id}";
//mysqli_query($mysqli,$sql);
echo($sql);
exit();
?>
