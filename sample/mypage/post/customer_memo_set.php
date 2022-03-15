<?
include_once('../../library/sql_post.php');
$c_id		=$_POST["c_id"];
$log		=$_POST["log"];
$memo_id	=$_POST["memo_id"];
$now		=date("Y.m.d H:i",$now_time);

if(!$log){
	$app=" `del`='1',";
}
if($memo_id){
	$sql ="UPDATE wp00000_customer_memo SET";
	$sql.=" `date`='{$now}',";
	$sql.=$app;
	$sql.=" `log`='{$log}'";
	$sql.=" WHERE id='{$memo_id}'";
	mysqli_query($mysqli,$sql);
	$tmp_auto=$memo_id;

}else{
	$sql ="INSERT INTO wp00000_customer_memo(`date`,cast_id,`customer_id`,`log`,del) VALUES ";
	$sql.=" ('{$now}','{$cast_data["id"]}','{$c_id}','{$log}','0')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);
}

if($log){
$log=str_replace("\n","<br>",$log);
$dat.="<div class=\"customer_memo_log\">";
$dat.="<div class=\"customer_memo_date\"><span class=\"customer_log_icon\"></span>{$now}";
$dat.="<div id=\"m_chg{$tmp_auto}\" class=\"customer_memo_chg\"></div>";
$dat.="<div id=\"m_del{$tmp_auto}\" class=\"customer_memo_del\"></div>";
$dat.="</div>";
$dat.="<div id=\"tr_memo_detail{$tmp_auto}\" class=\"customer_memo_log_in\">{$log}</div>";
$dat.="</div>";
echo $dat;
}

exit();
?>

