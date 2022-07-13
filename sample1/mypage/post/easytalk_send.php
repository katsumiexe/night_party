<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$send			=$_POST['send'];
$log			=$_POST['log'];
$img_code		=$_POST['img_code'];

$customer_id	=$_POST['customer_id'];
$customer_name	=$_POST['customer_name'];
$customer_mail	=$_POST['customer_mail'];

$cast_id		=$cast_data["id"];
$now_dat		=date("Y.m.d H:i");
$yesterday		=date("Y-m-d H:i:s",time()-86400);


$sql	 ="SELECT watch_date FROM ".TABLE_KEY."_easytalk";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND customer_id='{$customer_id}'";
$sql	.=" AND send_flg='1'";
$sql	.=" AND send_date>'{$yesterday}'";
$sql	.=" ORDER BY mail_id DESC";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
	if($row['watch_date'] == "0000-00-00 00:00:00"){
		$send_not=1;
	}
}

if($img_code){
	$img_name="m";
	for($n=0;$n<8;$n++){
		$r=rand(0,18);
		$s=substr($now_8,$n,1);
		$img_name.=$dec[$r][$s];	
	}

	$img_link="../../img/cast/{$box_no}/m/{$img_name}";

	$img	= imagecreatefromstring(base64_decode($img_code));	

	$img2	= imagecreatetruecolor(600,600);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);
//	imagepng($img2,$img_link.".png");

	$img2	= imagecreatetruecolor(200,200);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 200, 200, 600, 600);
	imagepng($img2,$img_link."_s.png");
	$tmp_img=substr($img_link,3).".png";

	$link_url="<img src=\"../img/cast/{$box_no}/m/{$img_name}.png\" class=\"mail_box_stamp\">";

}


	//----------------------------------------
/*
	$sql ="SELECT * FROM ".TABLE_KEY."_encode"; 
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$enc[$row["key"]]	=$row["value"];
			$dec[$row["gp"]][$row["value"]]	=$row["key"];	
			$rnd[$row["id"]]	=$row["key"];	
		}
	}
	//box_no----------------------------------------
	$id_8=substr("00000000".$cast_id,-8);
	$id_0	=$cast_id % 20;
	for($n=0;$n<8;$n++){
		$tmp_id=substr($id_8,$n,1);
		$box_no2.=$dec[$id_0][$tmp_id];
	}
	$box_no2.=$id_0;
*/


//SSID----------------------------------------
$n0=($cast_id % 720)+1;
$n1=rand(1, 720);
$n2=rand(1, 720);
$n3=rand(1, 720);
$n4=($customer_id % 720)+1;
$n5=rand(1, 9);
$ssid_key=$rnd[$n0].$rnd[$n1].$rnd[$n2].$rnd[$n3].$rnd[$n4].$dec[$n5][$send];


if($send_not != 1){

	$sql	 ="INSERT INTO ".TABLE_KEY."_ssid";
	$sql	.="(ssid,cast_id,customer_id,`del`,`date`,`mail`)";
	$sql	.="VALUES";
	$sql	.="('{$ssid_key}','{$cast_id}','{$customer_id}','0','{$now}','{$customer_mail}')";
//	mysqli_query($mysqli,$sql);

//------------------------------------------------
	mb_language("Japanese"); 
	mb_internal_encoding("UTF-8");
	$to			=$customer_mail;
	$title		="[Night Party]{$cast_data["genji"]}さんより";

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

	if($customer_name){
		$body	.=$customer_name."様\n\n";
	}

	$body	.=$cast_data["genji"]."さんからのメッセージが届いています\n";
	$body	.="下記のURLから内容をご確認ください。\n";
	$body	.=$admin_config["main_url"]."/easytalk.php?ss=".$ssid_key."\n\n\n";
	$body	.="===========================\n";
	$body	.="Night Party\n";
	$body	.="{$admin_config["main_url"]}/ngt\n";
	$body	.="080-1111-1111\n";
	$body	.="{$admin_config["main_mail"]}\n";
//	mb_send_mail($to, $title, $body, $header);
}

//------------------------------------------------
$sql	 ="INSERT INTO ".TABLE_KEY."_easytalk";
$sql	.="(send_date,customer_id,cast_id,send_flg,log,img,`mail_del`)";
$sql	.="VALUES";
$sql	.="('{$now}','{$customer_id}','{$cast_id}','{$send}','{$log}','{$img_name}','0')";

//mysqli_query($mysqli,$sql);
//$tmp_auto=mysqli_insert_id($mysqli);
$log=str_replace("\n","<br>",$log);

$dat.="<div class=\"mail_box_b\">";		
$dat.="<div class=\"mail_box_log_2 bg\">";		
$dat.="<div class=\"mail_box_log_in\">";		
$dat.=$log;		
$dat.="</div>";

$dat.=$link_url;		
$dat.="</div>";
$dat.="<span class=\"mail_box_date_b\"><span class=\"midoku\">未読</span>　{$now_dat}</span>";		
$dat.="<span id=\"m_del{$tmp_auto}\" class=\"mail_box_del\">× 削除</span>";
$dat.="</div>";
echo $dat;
exit();
?>
