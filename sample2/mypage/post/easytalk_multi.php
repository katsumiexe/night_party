<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$list			=$_POST['list'];
$log			=$_POST['log'];
$img_code		=str_replace("data:image/jpg;base64,","",$_POST['img_code']);

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
	imagepng($img2,$img_link.".png");
	imagewebp($img2,$img_link.".webp");

	$img2	= imagecreatetruecolor(200,200);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 200, 200, 600, 600);
	imagepng($img2,$img_link."_s.png");
	imagewebp($img2,$img_link."_s.webp");

	$tmp_img=substr($img_link,3).".png";
}

$yesterday		=date("Y-m-d H:i:s",time()-86400);

$sql1	 ="INSERT INTO ".TABLE_KEY."_easytalk";
$sql1	.="(send_date,customer_id,cast_id,send_flg,log,img,`mail_del`)";
$sql1	.="VALUES";

$sql2	 ="INSERT INTO ".TABLE_KEY."_ssid";
$sql2	.="(ssid,cast_id,customer_id,`date`,`mail`,`del`)";
$sql2	.="VALUES";

foreach($list as $a1){
	$sql	 ="SELECT mail_id FROM ".TABLE_KEY."_easytalk";
	$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
	$sql	.=" AND customer_id='{$a1}'";
	$sql	.=" AND send_flg='1'";
	$sql	.=" AND send_date>'{$yesterday}'";
	$sql	.=" AND watch_date IS NULL";
	$sql	.=" ORDER BY mail_id DESC";
	$sql	.=" LIMIT 1";


	if($result = mysqli_query($mysqli,$sql)){
		$row = mysqli_fetch_assoc($result);
		if($row['mail_id']){
			$send_not=1;
		}
	}

	$sql	 ="SELECT mail, name, nickname, block FROM ".TABLE_KEY."_customer";
	$sql	.=" WHERE id='{$a1}'";
	$sql	.=" LIMIT 1";

	if($result2 = mysqli_query($mysqli,$sql)){
		$customer_data = mysqli_fetch_assoc($result2);

		if(!$customer_data["nickname"]){
			$customer_data["nickname"]=$customer_data["name"];
		}
		if(!$customer_data["name"]){
			$customer_data["name"]=$customer_data["nickname"];
		}

		if($customer_data["block"] == 1){
			$tmp_img="";
		}else{
			$tmp_img=$img_name;
		}
	}

	$tmp_log=str_replace('[名前]',$customer_data["name"],$log);
	$tmp_log=str_replace('[呼び名]',$customer_data["nickname"],$tmp_log);

		
//SSID----------------------------------------
	$n0=($cast_id % 720)+1;
	$n1=rand(1, 720);
	$n2=rand(1, 720);
	$n3=rand(1, 720);
	$n4=($a1 % 720)+1;
	$n5=rand(1, 9);
	$ssid_key=$rnd[$n0].$rnd[$n1].$rnd[$n2].$rnd[$n3].$rnd[$n4].$dec[$n5][1];

	$sql2	.="('{$ssid_key}','{$cast_data["id"]}','{$a1}','{$now}','{$customer_data["mail"]}','0'),";

//------------------------------------------------
	if($send_not != 1){
		mb_language("Japanese"); 
		mb_internal_encoding("UTF-8");
		$to			=$customer_data["mail"];
		$title		="[Night Party]{$cast_data["genji"]}さんより";

		$from_mail	="{$admin_config["main_mail"]}";
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

		$body	 =$customer_data["nickname"]."様\n\n";
		$body	.=$cast_data["genji"]."さんからのメッセージが届いています\n";
		$body	.="下記のURLから内容をご確認ください。\n";
		$body	.="{$admin_config["main_url"]}/easytalk.php?ss=".$ssid_key."\n\n\n";
		$body	.="今後メッセージを受け取らない\n{$admin_config["main_url"]}/easytalk_status.php?ss=".$ssid_key."\n";
		$body	.="===========================\n";
		$body	.="Night Party\n";
		$body	.="{$admin_config["main_url"]}\n";
		$body	.="080-1111-1111\n";
		$body	.="{$admin_config["main_mail"]}\n";
		mb_send_mail($to, $title, $body, $header);
		sleep(1);
	//------------------------------------------------
	}

	$sql1	.="('{$now}','{$a1}','{$cast_data["id"]}','1','{$tmp_log}','{$tmp_img}','0'),";
}

$sql1=substr($sql1,0,-1);
$sql2=substr($sql2,0,-1);

mysqli_query($mysqli,$sql1);
mysqli_query($mysqli,$sql2);

$dat["result"]="<div class=\"filter_list\">";
$dat["result"].="送信しました(".count($list)."件)";
$dat["result"].="</div>";


$dat["midoku"]=0;
$sql	 ="SELECT COUNT(M.mail_id) AS cnt, M.customer_id FROM ".TABLE_KEY."_easytalk AS M";
$sql	.=" LEFT JOIN ".TABLE_KEY."_customer AS C ON (M.customer_id = C.id )";
$sql	.=" WHERE watch_date IS NULL";

$sql	.=" AND block<2";
$sql	.=" AND send_flg='2'";
$sql	.=" AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" GROUP BY M.customer_id"; 

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$dat["midoku"]++;
	}
}

if($dat["midoku"]>9){
	$dat["midoku"]="9+";
}

$sql	 ="SELECT M.customer_id, C.name, C.nickname, C.block, C.face, C.mail, MAX(send_date) AS l_date, MAX(mail_id) AS m_id FROM ".TABLE_KEY."_easytalk AS M";
$sql	 .=" LEFT JOIN ".TABLE_KEY."_customer AS C ON M.customer_id=C.id AND C.cast_id=M.cast_id";
$sql	 .=" WHERE M.cast_id='{$cast_data["id"]}'";
$sql	 .=" AND mail_del=0";
$sql	 .=" AND C.del=0";
$sql	 .=" AND opt=0";
$sql	 .=" AND block<2";
$sql	 .=" GROUP BY M.customer_id";
$sql	 .=" ORDER BY l_date DESC";
$sql	 .=" LIMIT 20";

$n=0; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(!$row["name"]){
			$row["name"]=$row["nickname"];
		}

		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}
	
		if (file_exists("../../img/cast/{$box_no}/c/{$row["face"]}.webp") && $admin_config["webp_select"] == 1) {
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.webp?t={$row["prm"]}\" class=\"mail_img_s\" alt=\"{$row["nickname"]}様\">";

		}elseif (file_exists("../../img/cast/{$box_no}/c/{$row["face"]}.png") ) {
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.png?t={$row["prm"]}\" class=\"mail_img_s\" alt=\"{$row["nickname"]}様\">";

		}else{
			$row["face"]="<img src=\"../img/customer_no_image.png\" class=\"mail_img_s\" alt=\"{$row["nickname"]}様\">";
		}

		$sql	 ="SELECT log, send_flg, watch_date FROM ".TABLE_KEY."_easytalk";
		$sql	 .=" WHERE mail_id='{$row["m_id"]}'";
		$sql	 .=" ORDER BY mail_id DESC";
		$sql	 .=" LIMIT 1";

		$result2 = mysqli_query($mysqli,$sql);
		$row2 = mysqli_fetch_assoc($result2);
	
		if($row2["send_flg"] == 2 && !$row2["watch_date"]){
		$row["yet"]=1;
		}

		$row["send_flg"]=$row2["send_flg"];
		$row["log_p"]=mb_substr($row2["log"],0,39);
		if(mb_strlen($row["log"])>39){
			$row["log_p"].="...";
		}

		$row["last_date"]=date("Y.m.d H:i",strtotime($row["l_date"]));
		$html.="<div id=\"mail_hist{$row["customer_id"]}\" class=\"mail_hist {$row["mail_yet"]}\">";
		$html.="{$row["face"]}";
		$html.="<span class=\"mail_date\">{$row["last_date"]}</span>";
		$html.="<span class=\"mail_log\">{$row["log_p"]}</span>";
		$html.="<span class=\"mail_gp\"></span><span id=\"mail_nickname{$s}\" class=\"mail_nickname\">{$row["nickname"]}</span>";

		if($row["yet"]==1){
			$html.="<span class=\"mail_count\"></span>";
		}
		$html.="<input type=\"hidden\" class=\"mail_name\" value=\"{$row["name"]}\">";
		$html.="<input type=\"hidden\" class=\"mail_address\" value=\"{$row["mail"]}\">";
		$html.="<input type=\"hidden\" class=\"mail_block\" value=\"{$row["block"]}\">";
		$html.="</div>";
	}
}

$dat["list"]=$html;

echo json_encode($dat);
exit();
?>
