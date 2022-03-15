<?
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$db		="mysql57.night-party.sakura.ne.jp";
$user	="night-party";
$pass	="npnp1941";
$dbn	="night-party_np";

$mysqli = mysqli_connect($db,$user,$pass,$dbn);
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$sql ="SELECT * FROM wp00000_encode"; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$enc[$row["key"]]	=$row["value"];
		$dec[$row["gp"]][$row["value"]]	=$row["key"];	
		$rnd[$row["id"]]	=$row["key"];	
	}
}

$id_8=substr("00000000".$cast_data["id"],-8);
$id_0	=$cast_data["id"] % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no.=$dec[$id_0][$tmp_id];
}
$box_no.=$id_0;

$sql =" SELECT config_key, config_value FROM wp00000_config";
if($res		= mysqli_query($mysqli,$sql)){
	while($row	= mysqli_fetch_assoc($res)){
		$admin_config[$row["config_key"]]	=$row["config_value"];
	}
}else{
	$msg="Configの設定が確認できません";
	die("Configの設定が確認できません");
}

$jst=32400;
$now_time	=time()+$jst;
$day_time	=time()-($admin_config["start_time"]*3600)+$jst;

$now		=date("Y-m-d H:i:s",$now_time);
$now_8		=date("Ymd",$now_time);
$now_w		=date("w",$now_time);
$now_count	=date("t",$now_time);
$now_month	=date("Y-m-01 00:00:00",$now_time);

$day		=date("Y-m-d H:i:s",$day_time);
$day_8		=date("Ymd",$day_time);
$day_w		=date("w",$day_time);
$day_count	=date("t",$day_time);
$day_month	=date("Y-m-01 00:00:00",$day_time);

$day_8_1	=date("Ymd",$day_time+86400);
$day_8_2	=date("Ymd",$day_time+172800);

$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
$ob_holiday = json_decode($holiday,true);
?>
