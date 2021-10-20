<?
$db		="localhost";
$user	="MkcuE8E.S#9y77";
$pass	="bjonvdlh";
$dbn	="bjonvdlh_np";

$mysqli = mysqli_connect($db,$pass,$user,$dbn);
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

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
		$config[$row["config_key"]]	=$row["config_value"];
	}
}else{
	$msg="Configの設定が確認できません";
	die("Configの設定が確認できません");
}

$now		=date("Y-m-d H:i:s");
$now_8		=date("Ymd");
$now_w		=date("w");
$now_count	=date("t");
$now_month	=date("Y-m-01 00:00:00");

$day_time	=time()-($config["start_time"]*3600);

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
