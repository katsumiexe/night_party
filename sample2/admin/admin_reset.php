<?
include_once('../library/sql.php');

/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$send		=$_POST["send"];
$admin_id	=$_POST["admin_id"];
$admin_pass	=$_POST["admin_pass"];
$admin_mail	=$_POST["admin_mail"];

$code		=$_REQUEST["code"];

if($send && $admin_id && $admin_pass && $admin_mail){
	$check_ymd=date("Y-m-d H:i:s",$send);
	$sql ="SELECT id FROM ".TABLE_KEY."_mypage_chg";
	$sql.=" WHERE date='{$check_ymd}'";
	$sql.=" AND done IS NULL";
	$sql.=" LIMIT 1";

	$result	=mysqli_query($mysqli,$sql);
	$row	=mysqli_fetch_assoc($result);

	if(!$row["id"]){
		$err_msg="ログイン情報の取得ができませんでした";

	}else{

		$sql ="UPDATE ".TABLE_KEY."_config SET";
		$sql .=" config_value='{$admin_id}'";
		$sql .=" WHERE config_key='admin_id'";
		mysqli_query($mysqli,$sql);

		$sql ="UPDATE ".TABLE_KEY."_config SET";
		$sql .=" config_value='{$admin_pass}'";
		$sql .=" WHERE config_key='admin_pass'";
		mysqli_query($mysqli,$sql);

		$sql ="UPDATE ".TABLE_KEY."_config SET";
		$sql .=" config_value='{$admin_mail}'";
		$sql .=" WHERE config_key='admin_mail'";
		mysqli_query($mysqli,$sql);

		$sql ="UPDATE ".TABLE_KEY."_mypage_chg SET done='1' WHERE id='{$row["id"]}'";
		mysqli_query($mysqli,$sql);

		mb_language("Japanese"); 
		mb_internal_encoding("UTF-8");
		$to			=$admin_mail;
		$title		="[{$admin_config["store_name"]}]登録情報の変更";

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
		$body	.="URL :{$admin_config["main_url"]}/{$admin_config["admin_url"]}/\n";
		$body	.="ID  :{$admin_id}\n";
		$body	.="PASS:********\n";

	$body	.="===========================\n";
	$body	.="{$admin_config["store_name"]}\n";
	$body	.=$admin_config["main_url"]."\n";
	$body	.="{$admin_config["main_tel"]}\n";
	$body	.="{$admin_config["main_mail"]}";
	mb_send_mail($to, $title, $body, $header);

	}


}elseif($code < time()-600){
	$err_msg="ログイン情報が取得できませんでした";

}else{
	$check_ymd=date("Y-m-d H:i:s",$code);
	$sql ="SELECT id FROM ".TABLE_KEY."_mypage_chg";
	$sql.=" WHERE date='{$check_ymd}'";
	$sql.=" AND done IS NULL";
	$sql.=" LIMIT 1";

	$result	=mysqli_query($mysqli,$sql);
	$row	=mysqli_fetch_assoc($result);

	if(!$row["id"]){
		$err_msg="ログイン情報が取得できません";
	}

}

?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/admin.js?t=<?=time()?>"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/admin.css?t=<?=time()?>">

<style>

.admin_box{
	width		:400px;
	text-align	:left;
	line-height	:22x;
	margin		:10px auto;
	padding	:10px;
	font-size	:16px;
	background	:linear-gradient(#ffffff,#fafafa);
	color		:#303030;
}

.admin_title{
	width		:400px;
	text-align	:left;
	line-height	:22px;
	margin		:10px auto;
	padding		:10px;
	font-size	:16px;
	background	:linear-gradient(#a0a0a0,#909090);
	color		:#fafafa;
}

</style>
</head>
<body class="body">
<div class="admin_title">登録情報</div>
<?if($send){?>
<div class="admin_box">
情報が変更されました<br>
</div>
<?}elseif($err_msg){?>
<div class="admin_box">
<?=$err_msg?>
</div>
<?}else{?>
<form method="post" action="./admin_reset.php">
<table class="config_sche " style="margin:0 auto;">
	<tr class="tr">
		<td class="config_prof_name">IDCODE</td>
		<td class="config_prof_style"><input name="admin_id" type="text" value="<?=$admin_config["admin_id"]?>" class="prof_name" required="required"></td>
	</tr>

	<tr class="tr">
		<td class="config_prof_name">PASSWORD</td>
		<td class="config_prof_style"><input name="admin_pass" type="text" value="<?=$admin_config["admin_pass"]?>" class="prof_name" required="required"></td>
	</tr>

	<tr class="tr">
		<td class="config_prof_name">ADMIN-MAIL</td>
		<td class="config_prof_style"><input name="admin_mail" type="text" value="<?=$admin_config["admin_mail"]?>" class="prof_name" required="required"></td>
	</tr>
</table>
<input type="hidden" name="send" value="<?=$code?>">
<button type="submit" style="width:406px; height:36px;margin:10px auto;background:#90a0ff; border:1px solid #303030;font-size:18px;color:#fafafa;font-weight:700">変更</button>
</form>
<?}?>
<a href="./index.php" style="font-size:18px;display:inline-block;margin:5px auto">TOPへ戻る</a>
</body>
</html>
