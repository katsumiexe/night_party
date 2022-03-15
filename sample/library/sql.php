<?
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$db		="mysql57.night-party.sakura.ne.jp";
$user	="night-party";
$pass	="npnp1941";
$dbn	="night-party_np";
$db_key	="wp_key";

$mysqli = mysqli_connect($db,$user,$pass,$dbn);

if(!$mysqli){
	error_log('Connection error: ' . mysqli_connect_error());
	die("接続error!!<br>\n");
}
mysqli_set_charset($mysqli,'utf8mb4'); 

/*--■乱数設定--*/

$sql ="SELECT * FROM wp00000_encode"; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$enc[$row["key"]]	=$row["value"];
		$dec[$row["gp"]][$row["value"]]	=$row["key"];	
		$rnd[$row["id"]]				=$row["value"];
	}
}


$sql ="SELECT config_key, config_value FROM wp00000_config";

if($res	= mysqli_query($mysqli,$sql)){
	while($row	= mysqli_fetch_assoc($res)){
		$admin_config[$row["config_key"]]=$row["config_value"];
	}

	$start_time	=$admin_config["start_time"];
	$start_week	=$admin_config["start_week"];

}else{
	$msg="接続エラー";
	die("接続エラー");
}

//■webPちぇっく------------------
$ua_list=$_SERVER['HTTP_USER_AGENT'];

$tmp=explode($ua_list," ");
if($tmp[5]){
	$tmp2=explode($tmp[5],"_");
}
if($tmp2<14 && $tmp[3]=="iPhone"){
	$admin_config["webp_select"]=0;
}

if (strstr($ua_list,'trident') || strstr($ua_list, 'msie')) {
	$admin_config["webp_select"]=0;
}
//■webPちぇっく------------------

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


$url=$_SERVER['REQUEST_URI'];
$tmp=explode("/",$url);
$f_key=array_key_last($tmp);

$f_mark=$tmp[$f_key];

if($f_mark ==""){
	$f_mark="index.php";
}

if(strpos($f_mark,"?")>0){
	$f_tmp=explode("?",$f_mark);
	$f_mark=$f_tmp[0];

	if(strpos($f_tmp[1],"&")>0){
		$f_tmp0	=explode("&",$f_tmp[1]);
		$f_tmp2	=explode("=",$f_tmp0[0]);
		$parm	=$f_tmp2[0];
		$value	=$f_tmp2[1];

	}else{
		$f_tmp2	=explode("=",$f_tmp[1]);
		$parm	=$f_tmp2[0];
		$value	=$f_tmp2[1];
	}
}

$t_re=$_SERVER["HTTP_REFERER"];
$t_ua=$_SERVER['HTTP_USER_AGENT'];
$t_ip=$_SERVER["REMOTE_ADDR"];
if(!$t_re) $t_re="null";
if(!$t_ua) $t_ua="null";
$sql="INSERT INTO wp00000_log(`date`,`ref`,`ua`,`ip`,`page`,`parm`,`value`,`days`) VALUES('{$now}','{$t_re}','{$t_ua}','{$t_ip}','{$f_mark}','{$parm}','{$value}','{$now_8}')";
mysqli_query($mysqli,$sql);
?>

