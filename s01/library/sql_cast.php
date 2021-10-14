<?
session_save_path('../mypage/session/');
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

$cast_data=array();
$mysqli = mysqli_connect("mysql57.night-party.sakura.ne.jp", "night-party", "npnp1941", "night-party_np");
if(!$mysqli){
	error_log('Connection error: ' . mysqli_connect_error());
	die("error!<br>\n");
}
mysqli_set_charset($mysqli,'utf8mb4'); 

$sql ="SELECT * FROM wp00000_encode"; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$enc[$row["key"]]	=$row["value"];
		$dec[$row["gp"]][$row["value"]]	=$row["key"];	
	}
}

if($_REQUEST["log_out"] == 1 || $_REQUEST["cast_page"] == 99){
	$_POST="";
	$_SESSION="";
	session_destroy();

}elseif($_REQUEST["easy_in"]){
	$ky=0;
	$easy_in=$_REQUEST["easy_in"];
	$_REQUEST["easy_in"]="";

	$easy_key=$enc[substr($easy_in,2,2)];
	$easy_in=substr($easy_in,4);

	$easy_list=floor(strlen($easy_in)/2);
	$easy_key=$easy_list-$easy_key;

	for($n=0;$n<$easy_list;$n++){
		$tmp_key=substr($easy_in,$easy_key*2,2);

		if($tmp_key == "0h"){
			$ky++;

		}elseif($tmp_key == "1h"){
			$ky++;
			$cast_page=3;
			$c_id=$_REQUEST["c_id"];

		}else{
			$ip[$ky].=$enc[$tmp_key];
		}

		$easy_key++;
		if($easy_key >=$easy_list){
			$easy_key=0;
		}
	}

	$sql="SELECT * FROM wp00000_cast";
	$sql.=" WHERE login_id='{$ip[0]}' AND login_pass='{$ip[1]}'";
	$sql.=" AND cast_status<3";
	$sql.=" LIMIT 1";
	$res = mysqli_query($mysqli,$sql);
	$row= mysqli_fetch_assoc($res);
	if($row["id"]){
		$sql="SELECT mail FROM wp00000_staff";
		$sql.=" WHERE staff_id='{$row["id"]}'";
		$sql.=" LIMIT 1";

		$res2 = mysqli_query($mysqli,$sql);
		$row2= mysqli_fetch_assoc($res2);

		$row["mail"]=$row2["mail"];
		$row["cast_time"]=time();

		$_SESSION= $row;

	}else{
		$err="IDもしくはパスワードが違います";
		$_SESSION="";
		session_destroy();
	}


}elseif($_REQUEST["chg_in"]){
	$ky=0;
	$easy_in=$_REQUEST["chg_in"];
	$_REQUEST["chg_in"]="";

	$easy_key=$enc[substr($easy_in,2,2)];
	$easy_in=substr($easy_in,4);

	$easy_list=floor(strlen($easy_in)/2);
	$easy_key=$easy_list-$easy_key;

	for($n=0;$n<$easy_list;$n++){
		$tmp_key=substr($easy_in,$easy_key*2,2);

		if($tmp_key == "0h"){
			$ky++;

		}elseif($tmp_key == "1h"){
			$ky++;
			$cast_page=3;
			$c_id=$_REQUEST["c_id"];

		}else{
			$ip[$ky].=$enc[$tmp_key];
		}

		$easy_key++;
		if($easy_key >=$easy_list){
			$easy_key=0;
		}
	}

	$chg_date=date("Y-m-d H:i:s",time()-3600);
	$sql="SELECT * FROM wp00000_mail_change";
	$sql.=" WHERE n_mail='{$ip[0]}' AND n_pass='{$ip[1]}'";
	$sql.=" AND cast_status<3";
	$sql.=" AND `date`>'{$chg_date}'";
	$sql.=" LIMIT 1";

	$res = mysqli_query($mysqli,$sql);
	$row= mysqli_fetch_assoc($res);

	if($row["id"]){
		$sql="SELECT * FROM wp00000_cast";
		$sql.=" WHERE login_id='{$ip[0]}'";
		$sql.=" AND cast_status<3";
		$sql.=" LIMIT 1";
		$res = mysqli_query($mysqli,$sql);
		$row= mysqli_fetch_assoc($res);

		$sql="SELECT mail FROM wp00000_staff";
		$sql.=" WHERE staff_id='{$row["id"]}'";
		$sql.=" LIMIT 1";

		$res2 = mysqli_query($mysqli,$sql);
		$row2= mysqli_fetch_assoc($res2);

		$row["mail"]=$row2["mail"];
		$row["cast_time"]=time();

		$_SESSION= $row;

	}else{
		$err="IDもしくはパスワードが違います";
		$_SESSION="";
		session_destroy();
	}




}elseif($_SESSION["cast_time"]+10800>time()){
	$cast_page	=$_REQUEST["cast_page"];
	$c_id		=$_REQUEST["c_id"];

	$_SESSION["cast_time"]=time();
	$_SESSION["cast_page"]=$cast_page;

/*
	$sql="SELECT * FROM wp00000_cast";
	$sql.=" WHERE id='{$_SESSION["id"]}'";
	$sql.=" AND cast_status<3";
	$sql.=" LIMIT 1";
	if($res = mysqli_query($mysqli,$sql)){
		$_SESSION= mysqli_fetch_assoc($res);
	}
*/

}elseif($_POST["log_in_set"] && $_POST["log_pass_set"]){

	$sql="SELECT * FROM wp00000_cast";
	$sql.=" WHERE login_id='{$_POST["log_in_set"]}' AND login_pass='{$_POST["log_pass_set"]}'";
	$sql.=" AND cast_status<3";
	$sql.=" LIMIT 1";
	$res = mysqli_query($mysqli,$sql);
	$row= mysqli_fetch_assoc($res);
	if($row["id"]){

		$sql="SELECT mail FROM wp00000_staff";
		$sql.=" WHERE staff_id='{$row["id"]}'";
		$sql.=" LIMIT 1";

		$res2 = mysqli_query($mysqli,$sql);
		$row2= mysqli_fetch_assoc($res2);

		$row["mail"]=$row2["mail"];
		$row["cast_time"]=time();
		$_SESSION= $row;

	}else{
		$err="IDもしくはパスワードが違います";
		$_SESSION="";
		session_destroy();
	}

}else{
	$_SESSION="";
	session_destroy();
}

if($_SESSION){
	$cast_data=$_SESSION;


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
	$day_base	=date("Y-m-d",$day_time);
	$day_8		=date("Ymd",$day_time);
	$day_w		=date("w",$day_time);
	$day_count	=date("t",$day_time);
	$day_month	=date("Y-m-01 00:00:00",$day_time);

	$day_8_1	=date("Ymd",$day_time+86400);
	$day_8_2	=date("Ymd",$day_time+172800);

	$day_md_1	=date("md",$day_time+86400);
	$day_md_2	=date("md",$day_time+172800);


	$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
	$ob_holiday = json_decode($holiday,true);
}
?>
