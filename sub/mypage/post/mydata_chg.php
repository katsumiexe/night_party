<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$new_mail=$_POST["new_mail"];
$new_pass=$_POST["new_pass"];

$sql="INSERT INTO ".TABLE_KEY."_mypage_chg(`cast_id`,`base_mail`,`base_pass`,`new_mail`,`new_pass`,`date`,`done`)";
$sql.=" VALUES('{$cast_data["id"]}','{$cast_data["mail"]}','{$cast_data["login_pass"]}','{$new_mail}','{$new_pass}','{$now}','0')";

mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli);

for($n=0;$n<strlen($tmp_auto);$n++){
	$ck=substr($tmp_auto,$n,1);
	$rnd=rand(1,19);
	$code.=$dec[$rnd][$ck];	
}

$code.="csc";	
for($n=0;$n<strlen($cast_data["id"]);$n++){
	$ck=substr($cast_data["id"],$n,1);
	$rnd=rand(1,19);
	$code.=$dec[$rnd][$ck];	
}

//------------------------------------------------
	mb_language("Japanese"); 
	mb_internal_encoding("UTF-8");
	$to			=$_POST["new_mail"];
	$title		="[Night Party]登録情報変更確認";

	$from_mail	=$admin_config["main_mail"];
	$from		="NightParty";
	$header = '';
	$header .= "Content-Type: text/plain \r\n";
	$header .= "Return-Path: " . $from_mail . " \r\n";
	$header .= "From: " . $from ."<".$from_mail.">\r\n";
//	$header .= "Sender: " . $from ."\r\n";
	$header .= "Reply-To: " . $from_mail . " \r\n";
	$header .= "Organization: " . $from_name . " \r\n";
	$header .= "X-Sender: " . $from_mail . " \r\n";
	$header .= "X-Priority: 3 \r\n";

	if($customer_name){
		$body	.=$customer_name."様\n\n";
	}

	$body	.="下記のURLより新しく決めたPASSWORDを入力してください。\n";
	$body	.=$admin_config["main_url"]."/".$admin_config["cast_url"]."/index.php?chg_flg=".$code."\n\n\n";
	$body	.="※30分以上経ちますとリンクが無効になります\n";

	$body	.="===========================\n";
	$body	.="{$admin_config["store_name"]}\n";
	$body	.="{$admin_config["main_url"]}\n";
	$body	.="{$admin_config["main_mail"]}\n";
	mb_send_mail($to, $title, $body, $header);

exit();
?>
