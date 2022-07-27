<?
session_save_path('./session/');
ini_set('session.gc_maxlifetime', 3*60*60); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', FALSE);
ini_set('session.use_only_cookies', TRUE);
session_start();
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
include_once('connect.php');

$cast_page=$_REQUEST["cast_page"];
$prm=$_POST["prm"];
if($prm){
	$cast_page =$prm-1;
}

$sql ="SELECT * FROM ".TABLE_KEY."_encode"; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$enc[$row["key"]]	=$row["value"];
		$dec[$row["gp"]][$row["value"]]	=$row["key"];	
	}
}

$sql =" SELECT config_key, config_value FROM ".TABLE_KEY."_config";
if($res		= mysqli_query($mysqli,$sql)){
	while($row	= mysqli_fetch_assoc($res)){
		$admin_config[$row["config_key"]]	=$row["config_value"];
	}

}else{
	$msg="Configの設定が確認できません";
	die("Configの設定が確認できません");
}

$jst=$admin_config["jst"]*3600;
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

$url = "https://katsumiexe.github.io/pages/holiday.json";
$cp = curl_init();
curl_setopt($cp, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($cp, CURLOPT_URL, $url);
curl_setopt($cp, CURLOPT_TIMEOUT, 60);
$holiday = curl_exec($cp);
curl_close($cp);
$ob_holiday = json_decode($holiday,true);

$day_md_1	=date("md",$day_time+86400);
$day_md_2	=date("md",$day_time+172800);

$chg_flg=$_REQUEST["chg_flg"];


$sql="SELECT * FROM ".TABLE_KEY."_cast";
$sql.=" WHERE id='12346'";
$sql.=" AND cast_status<3";
$sql.=" LIMIT 1";
$res = mysqli_query($mysqli,$sql);
$row= mysqli_fetch_assoc($res);

if($row["id"]){
	$sql="SELECT mail FROM ".TABLE_KEY."_staff";
	$sql.=" WHERE staff_id='{$row["id"]}'";
	$sql.=" LIMIT 1";

	$res2 = mysqli_query($mysqli,$sql);
	$row2= mysqli_fetch_assoc($res2);

	$row["mail"]=$row2["mail"];
	$row["cast_time"]=time();
	$_SESSION= $row;
	$cast_data=$_SESSION;

	$id_8=substr("00000000".$cast_data["id"],-8);
	$id_0	=$cast_data["id"] % 20;

	for($n=0;$n<8;$n++){
		$tmp_id=substr($id_8,$n,1);
		$box_no.=$dec[$id_0][$tmp_id];
	}
		$box_no.=$id_0;
}



if($_REQUEST["pg"] || $_SESSION["pg_code"]){
	if($_REQUEST["pg"]){
		$pg_code=$_REQUEST["pg"];
		$_SESSION["pg_code"]=$_REQUEST["pg"]

	}else{
		$pg_code=$_SESSION["pg_code"];

	}

	$t_re=$_SERVER["HTTP_REFERER"];
	$t_ua=$_SERVER['HTTP_USER_AGENT'];
	$t_ip=$_SERVER["REMOTE_ADDR"];

	if(!$t_re) $t_re="null";
	if(!$t_ua) $t_ua="null";
	$sql="INSERT INTO ".TABLE_KEY."_log(`date`,`ref`,`ua`,`ip`,`page`,`parm`,`value`,`code`,`days`) VALUES('{$now}','{$t_re}','{$t_ua}','{$t_ip}','{$f_mark}','{$parm}','{$value}','{$pg_code}','{$now_8}')";
}


?>
