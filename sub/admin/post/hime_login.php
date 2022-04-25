<?
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

include_once('../../library/sql_post.php');
$id		=$_POST['id'];

if($id == 0){
	$code=time()+$jst;

	$date_code=date("Y-m-d H:i:s",$code);

	$sql	 ="INSERT INTO ".TABLE_KEY."_mypage_chg(`cast_id`,`date`) VALUES('0','{$date_code}') ";
	mysqli_query($mysqli,$sql);
echo $sql;	
	mb_language("Japanese"); 
	mb_internal_encoding("UTF-8");
	$to			=$admin_config["admin_mail"];
	$title		="[{$admin_config["store_name"]}]登録情報確認";

	$from_mail	=$admin_config["main_mail"];
	$from		=$admin_config["store_name"];
	$header = '';
	$header .= "Content-Type: text/plain \r\n";
	$header .= "Return-Path: " . $from_mail . " \r\n";
	$header .= "From: " . $from ."<".$from_mail.">\r\n";
	$header .= "Reply-To: " . $from_mail . " \r\n";
	$header .= "Organization: " . $from_name . " \r\n";
	$header .= "X-Sender: " . $from_mail . " \r\n";
	$header .= "X-Priority: 3 \r\n";

	$body	.="{$title}\n\n";
	$body	.="CMSよりADMIN情報の確認、変更の申請がされました。\n";
	$body	.="下記よりログインの上、ご確認ください。\n";
	$body	.="※設定期限は10分です。超過した場合このリンクは使えません。\nお手数ですが再度申請くださいませ\n";

	$body	.=$admin_config["main_url"]."/{$admin_config["admin_url"]}/admin_reset.php?code=".$code."\n";
	$body	.="===========================\n";
	$body	.="{$admin_config["store_name"]}\n";
	$body	.=$admin_config["main_url"]."\n";
	$body	.="{$admin_config["main_tel"]}\n";
	$body	.="{$admin_config["main_mail"]}";
	mb_send_mail($to, $title, $body, $header);


}else{
	$sql	 ="SELECT S.staff_id, S.mail, C.genji, C.login_id, C.login_pass FROM ".TABLE_KEY."_staff AS S";
	$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON S.staff_id=C.id";
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
		$title		="HIMEカルテ　ログインメール";

		$from_mail	=$admin_config["main_mail"];
		$from		=$admin_config["store_name"];

		$header = '';
		$header .= "Content-Type: text/plain \r\n";
		$header .= "Return-Path: " . $from_mail . " \r\n";
		$header .= "From: " . $from ."<".$from_mail.">\r\n";
		$header .= "Reply-To: " . $from_mail . " \r\n";
		$header .= "Organization: " . $from_name . " \r\n";
		$header .= "X-Sender: " . $from_mail . " \r\n";
		$header .= "X-Priority: 3 \r\n";

		$body	.="HIMEカルテ　ログインメール\n\n";
		$body	.="URL :".$admin_config["main_url"]."/{$admin_config["cast_url"]}/\n";
		$body	.="ID  :".$dat["login_id"]."\n";
		$body	.="PASS:".$dat["login_pass"]."\n\n\n";

		$body	.="簡単ログイン\n";
		$body	.=$admin_config["main_url"]."/{$admin_config["cast_url"]}/index.php?easy_in=".$log_enc."\n";
		$body	.="===========================\n";
		$body	.="{$admin_config["store_name"]}\n";
		$body	.=$admin_config["main_url"]."\n";
		$body	.="{$admin_config["main_tel"]}\n";
		$body	.="{$admin_config["main_mail"]}";
	mb_send_mail($to, $title, $body, $header);
}
exit();
?>
