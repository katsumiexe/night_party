<?
include_once('../../library/sql_post.php');
$c_id		=$_POST["c_id"];
$item_name	=$_POST["item_name"];
$item_icon	=$_POST["item_icon"];
$item_color	=$_POST["item_color"];
$item_price	=$_POST["item_price"];

$yy			=substr('0000'.$_POST["yy"],-4,4);
$mm			=substr('00'.$_POST["mm"],-2,2);
$dd			=substr('00'.$_POST["dd"],-2,2);

$hh_s		=substr('00'.$_POST["hh_s"],-2,2);
$ii_s		=substr('00'.$_POST["ii_s"],-2,2);

$hh_e		=substr('00'.$_POST["hh_e"],-2,2);
$ii_e		=substr('00'.$_POST["ii_e"],-2,2);

$log		=$_POST["log"];
$chg_id		=$_POST["chg_id"];

$sdate	=$yy.$mm.$dd;

$stime	=$hh_s.$ii_s;
$etime	=$hh_e.$ii_e;

if(!$chg_id){
	$sql ="INSERT INTO wp00000_cast_log(`date`,`sdate`,`stime`,`etime`,`cast_id`,`customer_id`,`log`) VALUES ";
	$sql.="('{$now}','{$sdate}','{$stime}','{$etime}','{$cast_data["id"]}','{$c_id}','{$log}')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);

	$dat.="<tr><td class=\"customer_memo_tag\">";
	$dat.="<div class=\"customer_log_date\"> <span class=\"customer_log_icon\"></span>{$sdate}　{$stime} - {$etime}</div>";
	$dat.="<span class=\"sel_box_left\">{$log}</span>";
	$dat.="<span class=\"sel_box_right\">";

	$sql_log ="INSERT INTO wp00000_cast_log_list(`master_id`,`log_color`,`log_icon`,`log_comm`,`log_price`) VALUES ";

	foreach($item_name as $a1 => $a2){
		$item_color[$a1]=str_replace("rgb(","",$item_color[$a1]);
		$item_color[$a1]=str_replace(")","",$item_color[$a1]);
		$tmp_color=explode(",",$item_color[$a1]);

		$tmp_1=substr('00'.dechex($tmp_color[0]),-2,2);
		$tmp_2=substr('00'.dechex($tmp_color[1]),-2,2);
		$tmp_3=substr('00'.dechex($tmp_color[2]),-2,2);

		$tmp="#".$tmp_1.$tmp_2.$tmp_3;

		$sql.=" ('{$tmp_auto}','{$tmp}','{$item_icon[$a1]}','{$item_name[$a1]}','{$item_price[$a1]}'),";
		$dat.="<div class=\"customer_log_item\" style=\"border:1px solid {$dat3["log_color"]}; color:{$dat3["log_color"]};\">";
		$app.="<span class=\"log_item_icon\">{$item_icon[$a1]}</span>";
		$app.="<span class=\"log_item_name\">{$item_comm[$a1]}</span>";
		$app.="<span class=\"log_item_price\">{$item_price[$a1]}</span>";
		$app.="</div>";
	}
	$sql=substr($sql,0,-1);
	mysqli_query($mysqli,$sql);
	$dat.=$app."</span></td></tr>";

}else{
	for($n=0;$n<count($chglist);$n++){
		$tmp=str_replace("i","",$chglist[$n]);
		$sql=" UPDATE wp00000_cast_log_table SET";

		$sql.=" item_name='{$item_name[$tmp]}',";
		$sql.=" item_icon='{$item_icon[$tmp]}',";
		$sql.=" item_color='{$item_color[$tmp]}',";
		$sql.=" price='{$item_price[$tmp]}'";

		$sql.=" WHERE cast_id='{$cast_data["id"]}'";
		$sql.=" AND sort='{$n}'";
		mysqli_query($mysqli,$sql);
	}
}
echo $dat;
exit();
?>
