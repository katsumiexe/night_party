<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$item_name	=$_POST["item_name"];
$item_icon	=$_POST["item_icon"];
$item_color	=$_POST["item_color"];
$item_price	=$_POST["item_price"];

$c_id		=$_POST["c_id"];
$log		=$_POST["log"];
$chg		=$_POST["chg"];
$del		=$_POST["del"];
$pts		=$_POST["pts"];

$sdate	=$_POST["local_dt"];
$stime	=$_POST["local_st"];
$etime	=$_POST["local_ed"];

if($del > 0){//■削除
	$sql="DELETE FROM wp00000_cast_log WHERE log_id='{$del}'";
	mysqli_query($mysqli,$sql);

	$sql="DELETE FROM wp00000_cast_log_list WHERE master_id='{$del}'";
	mysqli_query($mysqli,$sql);
	exit();
}

$tmp_date=$_POST["local_dt"]." ".$_POST["local_st"].":00"; 
$days=date("Y-m-d",strtotime($tmp_date)-($admin_config["start_time"]*3600));

if($chg){//■変更
	$sql=" UPDATE wp00000_cast_log SET";
	$sql.=" sdate='{$sdate}',";
	$sql.=" stime='{$stime}',";
	$sql.=" etime='{$etime}',";
	$sql.=" log='{$log}',";
	$sql.=" pts='{$pts}',";
	$sql.=" days='{$days}'";
	$sql.=" WHERE log_id='{$chg}'";
	mysqli_query($mysqli,$sql);

	$sql="DELETE FROM wp00000_cast_log_list WHERE master_id='{$chg}'";
	mysqli_query($mysqli,$sql);
	$tmp_auto=$chg;

}else{//新規
	$sql ="INSERT INTO wp00000_cast_log(`date`,`sdate`,`stime`,`etime`,`cast_id`,`customer_id`,`log`,`pts`,`days`,`del`) VALUES ";
	$sql.=" ('{$now}','{$sdate}','{$stime}','{$etime}','{$cast_data["id"]}','{$c_id}','{$log}','{$pts}','{$days}','0')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);
}

$log=str_replace("\n","<br>",$log);

$dat.="<div class=\"customer_memo_log\">";
$dat.="<div class=\"customer_memo_date\"><span class=\"customer_log_icon\"></span><span class=\"customer_log_date_detail\">{$sdate} {$stime}-{$etime}</span>";
$dat.="<div id=\"l_chg{$tmp_auto}\" class=\"customer_log_chg\"></div>";
$dat.="<div id=\"l_del{$tmp_auto}\" class=\"customer_log_del\"></div>";
$dat.="</div>";
$dat.="<div id=\"tr_log_detail{$tmp_auto}\" class=\"customer_memo_log_in\">";

$dat.="<div class=\"customer_log_memo\">";
$dat.="{$log}";
$dat.="</div>";

$dat.="<div class=\"customer_log_item item_pts\" style=\"border:1px solid #606090; background:#606090; color:#fafafa;\">";
$dat.="<span class=\"sel_log_icon_s\"></span>";
$dat.="<span class=\"sel_log_comm_s\">利用総額</span>";
$dat.="<span class=\"sel_log_price_s\">{$pts}</span>";
$dat.="</div>";

$dat.="<div class=\"customer_log_list\">";
if($item_name){
	$sql_log ="INSERT INTO wp00000_cast_log_list(`master_id`,`log_color`,`log_icon`,`log_comm`,`log_price`,`del`) VALUES ";

	foreach($item_name as $a1 => $a2){
		$item_color[$a1]=str_replace("rgb(","",$item_color[$a1]);
		$item_color[$a1]=str_replace(")","",$item_color[$a1]);
		$tmp_color=explode(",",$item_color[$a1]);

		$tmp_1=substr('00'.dechex($tmp_color[0]),-2,2);
		$tmp_2=substr('00'.dechex($tmp_color[1]),-2,2);
		$tmp_3=substr('00'.dechex($tmp_color[2]),-2,2);
		$tmp="#".$tmp_1.$tmp_2.$tmp_3;

		$sql_log.=" ('{$tmp_auto}','{$tmp}','{$item_icon[$a1]}','{$item_name[$a1]}','{$item_price[$a1]}','0'),";

		$app.="<div class=\"customer_log_item\" style=\"border:1px solid {$tmp}; color:{$tmp};\">";
		$app.="<span class=\"sel_log_icon_s\">{$item_icon[$a1]}</span>";
		$app.="<span class=\"sel_log_comm_s\">{$item_name[$a1]}</span>";
		$app.="<span class=\"sel_log_price_s\">{$item_price[$a1]}</span>";
		$app.="</div>";
	}
	$sql_log=substr($sql_log,0,-1);
	mysqli_query($mysqli,$sql_log);
}
$dat.=$app;
$dat.="</div>";
echo $dat;
exit();
?>
