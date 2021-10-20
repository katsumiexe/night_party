<?
$db		="localhost";
$user	="MkcuE8E.S#9y77";
$pass	="bjonvdlh";
$dbn	="bjonvdlh_np";

$mysqli = mysqli_connect($db,$pass,$user,$dbn);

if(!$mysqli){
	error_log('Connection error: ' . mysqli_connect_error());
	die("接続error!!<br>\n");
}
mysqli_set_charset($mysqli,'utf8mb4'); 



/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

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
$tmp2=explode($tmp[5],"_");
if($tmp2<14 && $tmp[3]=="iPhone"){
	$admin_config["webp_select"]=0;
}

if (strstr($ua_list,'trident') || strstr($ua_list, 'msie')) {
	$admin_config["webp_select"]=0;
}
//■webPちぇっく------------------

$now		=date("Y-m-d H:i:s");
$now_8		=date("Ymd");
$now_w		=date("w");
$now_count	=date("t");
$now_month	=date("Y-m-01 00:00:00");

$day_time	=time()-($start_time*3600);

$day		=date("Y-m-d H:i:s",$day_time);
$day_8		=date("Ymd",$day_time);
$day_w		=date("w",$day_time);
$day_count	=date("t",$day_time);
$day_month	=date("Y-m-01 00:00:00",$day_time);

$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
$ob_holiday = json_decode($holiday,true);
//$ob_holiday["20200101"];

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
$sql="INSERT INTO wp00000_log(`date`,`ref`,`ua`,`ip`,`page`,`parm`,`value`) VALUES('{$now}','{$t_re}','{$t_ua}','{$t_ip}','{$f_mark}','{$parm}','{$value}')";
mysqli_query($mysqli,$sql);

?>
