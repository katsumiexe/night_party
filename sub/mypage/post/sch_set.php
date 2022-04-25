<?
include_once('../../library/sql_post.php');
$base_day	=$_POST['base_day']+86400*7;

$st=date("Ymd",$base_day);
$ed=date("Ymd",$base_day + 86400 * 7 );

$sel_in		=$_POST['sel_in'];
$sel_out	=$_POST['sel_out'];

$sql_log="INSERT INTO ".TABLE_KEY."_schedule ";
$sql_log.="(sche_date,date,cast_id,stime,etime,signet)";
$sql_log.="VALUES";

$sql="SELECT * FROM ".TABLE_KEY."_schedule ";
$sql.=" WHERE sche_date>={$st}";
$sql.=" AND sche_date<{$ed}";
$sql.=" AND cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY id ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$dat[$row["sche_date"]]["s"]=$row["stime"];
		$dat[$row["sche_date"]]["e"]=$row["etime"];
	}
}

for($n=0;$n<7;$n++){
	if(!$sel_in[$n] || !$sel_out[$n]){
		$sel_in[$n]="";
		$sel_out[$n]="";
	}

	$day_8=date("Ymd",$base_day+86400*$n);
	if($day_8 >=$now_8){
		if($dat[$day_8]["s"] !== $sel_in[$n] || $dat[$day_8]["e"] !== $sel_out[$n]){

			$sql_log_app.="('{$day_8}','{$now}','{$cast_data["id"]}','{$sel_in[$n]}','{$sel_out[$n]}','0'),";
			$day_date[$day_8]=$sel_in[$n];
		}
	}
}

if($sql_log_app){
	$sql_log.=substr($sql_log_app,0,-1);
	mysqli_query($mysqli,$sql_log);
}

echo json_encode($day_date);
exit();
?>

