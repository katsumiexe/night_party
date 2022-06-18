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

$sql ="SELECT * FROM ".TABLE_KEY."_encode"; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$enc[$row["key"]]	=$row["value"];
		$dec[$row["gp"]][$row["value"]]	=$row["key"];	
		$rnd[$row["id"]]	=$row["key"];	
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


if($_REQUEST["code"]){

}elseif($_POST["menu_post"] === "logout"){
	$_POST="";
	$_SESSION="";
	session_destroy();
	$manage="";

}elseif(($_POST["admin_in"] == $admin_config["admin_id"] || $_POST["admin_pass"] == $admin_config["admin_pass"]) && ($_POST["admin_in"] || $_POST["admin_pass"])){
	$_SESSION["session_time"]=time();
	$manage=$_SESSION;

}elseif($_SESSION["session_time"]+10800+$jst>time()){
	$_SESSION["session_time"]=time();
	$manage=$_SESSION;

}else{
	if($_POST["admin_in"] || $_POST["admin_pass"]){
		$err_msg="IDもしくはPASSWORDが一致しません";
	}
	$_POST="";
	$_SESSION="";
	session_destroy();
	$manage="";
}
?>
