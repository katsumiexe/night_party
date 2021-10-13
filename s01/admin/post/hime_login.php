<?
include_once('../../library/sql_admin.php');
	$id		=$_POST['id'];

$sql	 ="SELECT S.staff_id, S.mail, C.genji, C.login_id, C.login_pass FROM wp01_0staff AS S";
$sql	.=" LEFT JOIN wp01_0cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE staff_id='{$id}'";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$dat = mysqli_fetch_assoc($result);
}

	$id_8=substr("00000000".$dat["staff_id"],-8);
	$id_0	=$dat["staff_id"] % 20;

	for($n=0;$n<8;$n++){
		$tmp_id=substr($id_8,$n,1);
		$box_no2.=$dec[$id_0][$tmp_id];
	}
	$box_no2.=$id_0;

	$c=strlen($dat["login_id"]);
	for($n=0;$n<$c;$n++){
		$tmp_rnd=rand(0,19);
		$tmp_enc=substr($dat["login_id"],$n,1);
		$log_enc.=$dec[$tmp_rnd][$tmp_enc];
	}

	$log_enc.="0h";
	$tmp_rnd=rand(0,19);
	$tmp_set=rand(1,floor(strlen($log_enc)/2));

	$c=strlen($dat["login_pass"]);
	for($n=0;$n<$c;$n++){
		$tmp_rnd=rand(0,19);
		$tmp_enc=substr($dat["login_pass"],$n,1);
		$log_enc.=$dec[$tmp_rnd][$tmp_enc];
	}

	$set_a=substr($log_enc,0,$tmp_set*2);
	$set_b=substr($log_enc,$tmp_set*2);
	$log_enc=$set_b.$set_a;
	$log_enc="na".$dec[$tmp_rnd][$tmp_set].$log_enc;

	mb_language("Japanese"); 
	mb_internal_encoding("UTF-8");
	$to			=$dat["mail"];
	$title		="[Night Party]HIMEカルテ　ログインメール";

	$from_mail	="info@arpino.fun";
	$from		="NightParty";
	$header = '';
	$header .= "Content-Type: text/plain \r\n";
	$header .= "Return-Path: " . $from_mail . " \r\n";
	$header .= "From: " . $from ."<".$from_mail.">\r\n";
	$header .= "Reply-To: " . $from_mail . " \r\n";
	$header .= "Organization: " . $from_name . " \r\n";
	$header .= "X-Sender: " . $from_mail . " \r\n";
	$header .= "X-Priority: 3 \r\n";

	$body	.="HIMEカルテ　ログインメール\n\n";
	$body	.="URL :".$config["main_url"]."/mypage/\n";
	$body	.="ID  :".$dat["login_id"]."\n";
	$body	.="PASS:".$dat["login_pass"]."\n";

	$body	.="簡単ログイン\n";
	$body	.=$config["main_url"]."/mypage/index.php?easy_in=".$log_enc."\n\n\n";
	$body	.="===========================\n";
	$body	.="Night Party\n";
	$body	.=$config["main_url"]."\n";
	$body	.="080-1111-1111\n";
	$body	.="info@piyo-piyo.work\n";

mb_send_mail($to, $title, $body, $header);

exit();
?>
