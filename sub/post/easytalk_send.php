<?
include_once('../library/sql.php');

ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);


$send			=$_POST['send'];
$log			=$_POST['log'];
$img_code		=$_POST['img_code'];
$now_dat		=date("Y.m.d H:i",$now_time);
$img_key		="";
$sid			=$_POST['sid'];

if($log || $img_code){

$sql	 ="SELECT I.cast_id, I.customer_id, C.nickname, A.login_id, A.login_pass, C.name, S.mail,C.opt FROM ".TABLE_KEY."_ssid AS I";
$sql	.=" LEFT JOIN ".TABLE_KEY."_staff AS S ON I.cast_id=S.staff_id";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS A ON I.cast_id=A.id";
$sql	.=" LEFT JOIN ".TABLE_KEY."_customer AS C ON I.customer_id=C.id";
$sql	.=" WHERE ssid='{$sid}'";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$dat = mysqli_fetch_assoc($result);
}
if(!$dat["nickname"]) {
	$dat["nickname"]=$dat["name"];
}

//box_no----------------------------------------
$id_8=substr("00000000".$dat["cast_id"],-8);
$id_0	=$dat["cast_id"] % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no2.=$dec[$id_0][$tmp_id];
}
$box_no2.=$id_0;

//SSID----------------------------------------
/*
$n0=($cast_id % 720)+1;
$n1=rand(1, 720);
$n2=rand(1, 720);
$n3=rand(1, 720);
$n4=($customer_id % 720)+1;
$n5=rand(1, 9);
$ssid_key=$rnd[$n0].$rnd[$n1].$rnd[$n2].$rnd[$n3].$rnd[$n4].$dec[$n5][$send];
*/

if($dat["mail"] && $dat["opt"] ==0){

	$c=strlen($dat["login_id"]);

	for($n=0;$n<$c;$n++){
		$tmp_rnd=rand(0,19);
		$tmp_enc=substr($dat["login_id"],$n,1);
		$log_enc.=$dec[$tmp_rnd][$tmp_enc];
	}

	$log_enc.="1h";
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
	$title		="[Night Party]{$dat["nickname"]}様より";

	$from_mail	="info@arpino.fun";
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

	$body	.=$dat["nickname"]."さんからのメッセージが届いています\n";
	$body	.="下記のURLから内容をご確認ください。\n";
	$body	.=$admin_config["main_url"]."/".$admin_config["cast_url"]."/index.php?easy_in=".$log_enc."&c_id=".$dat["customer_id"]."\n\n\n";
	$body	.="===========================\n";
	$body	.="Night Party\n";
	$body	.=$admin_config["main_url"]."\n";
	$body	.="080-1111-1111\n";
	$body	.="info@piyo-piyo.work\n";
	mb_send_mail($to, $title, $body, $header);
}


//------------------------------------------------

if($img_code){
	$img_name="m";
	for($n=0;$n<8;$n++){
		$r=rand(0,18);
		$s=substr($now_8,$n,1);
		$img_name.=$dec[$r][$s];	
	}

	$img_link="../img/cast/{$box_no2}/m/{$img_name}";

	$img	= imagecreatefromstring(base64_decode($img_code));	

	$img2	= imagecreatetruecolor(600,600);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);
	imagepng($img2,$img_link.".png");
	imagewebp($img2,$img_link.".webp");

	$img2	= imagecreatetruecolor(200,200);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 200, 200, 600, 600);
	imagepng($img2,$img_link."_s.png");
	imagewebp($img2,$img_link."_s.webp");

	$tmp_img=substr($img_link,3).".png";
	$link_url="<img src=\"./img/cast/{$box_no2}/m/{$img_name}.png\" class=\"blog_img\">";
}

$sql	 ="INSERT INTO ".TABLE_KEY."_easytalk";
$sql	.="(send_date,customer_id,cast_id,send_flg,log,img,`mail_del`)";
$sql	.="VALUES";
$sql	.="('{$now}','{$dat["customer_id"]}','{$dat["cast_id"]}','{$send}','{$log}','{$img_name}','0')";
mysqli_query($mysqli,$sql);

$log=str_replace("\n","<br>",$log);
$dat.="<div class=\"mail_box_b\">";		
$dat.="<span class=\"mail_box_date_b\">{$now_dat}　<span class=\"midoku\">未読</span></span>";		
$dat.="<div class=\"mail_box_log_{$send} bg\">";		
$dat.="<div class=\"mail_box_log_in\">";		
$dat.=$log;		
$dat.="</div>";

$dat.=$link_url;		
$dat.="</div>";
$dat.="</div>";

echo $dat;
}
exit();
?>
