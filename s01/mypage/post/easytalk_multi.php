<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$list			=$_POST['list'];
$log			=$_POST['log'];
$img_code		=str_replace("data:image/jpg;base64,","",$_POST['img_code']);

//box_no---------------------------------------
/*
$id_8=substr("00000000".$cast_data["id"],-8);
$id_0	=$cast_data["id"] % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no2.=$dec[$id_0][$tmp_id];
}
*/

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

	$img2	= imagecreatetruecolor(200,200);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 200, 200, 600, 600);
	imagepng($img2,$img_link."_s.png");
	$tmp_img=substr($img_link,3).".png";
}

$yesterday		=date("Y-m-d H:i:s",time()-86400);
foreach($list as $a1){
	$sql	 ="SELECT watch_date FROM wp01_0easytalk";
	$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
	$sql	.=" AND customer_id='{$a1}'";
	$sql	.=" AND send_flg='1'";
	$sql	.=" AND send_date>'{$yesterday}'";
	$sql	.=" AND watch_date='0000-00-00 00:00:00'";
	$sql	.=" ORDER BY mail_id DESC";
	$sql	.=" LIMIT 1";

	if($result = mysqli_query($mysqli,$sql)){
		$row = mysqli_fetch_assoc($result);
		if($row['watch_date'] == "0000-00-00 00:00:00"){
			$send_not=1;
		}
	}

	$sql	 ="SELECT mail, name, nickname, block FROM wp01_0customer";
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

	$sql	 ="INSERT INTO wp01_0ssid";
	$sql	.="(ssid,cast_id,customer_id,`date`,`mail`)";
	$sql	.="VALUES";
	$sql	.="('{$ssid_key}','{$cast_data["id"]}','{$a1}','{$now}','{$customer_data["mail"]}')";
	mysqli_query($mysqli,$sql);

//------------------------------------------------
	if($send_not != 1){
		mb_language("Japanese"); 
		mb_internal_encoding("UTF-8");
		$to			=$customer_data["mail"];
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

		$body	 =$customer_data["nickname"]."様\n\n";
		$body	.=$cast_data["genji"]."さんからのメッセージが届いています\n";
		$body	.="下記のURLから内容をご確認ください。\n";
		$body	.="https://arpino.fun/ngt/easytalk.php?ss=".$ssid_key."\n\n\n";
		$body	.="今後メッセージを受け取らない\nhttps://arpino.fun/ngt/easytalk_status.php?ss=".$ssid_key."\n";
		$body	.="===========================\n";
		$body	.="Night Party\n";
		$body	.="https://arpino.fun/ngt\n";
		$body	.="080-1111-1111\n";
		$body	.="info@piyo-piyo.work\n";
		mb_send_mail($to, $title, $body, $header);
		sleep(1);
	//------------------------------------------------
	}

	$sql	 ="INSERT INTO wp01_0easytalk";
	$sql	.="(send_date,customer_id,cast_id,send_flg,log,img)";
	$sql	.="VALUES";
	$sql	.="('{$now}','{$a1}','{$cast_data["id"]}','1','{$tmp_log}','{$tmp_img}')";
	mysqli_query($mysqli,$sql);
}

$html="<div class=\"filter_list\">";
$html.="送信しました(".count($list)."件)";
$html.="</div>";
echo $html;
exit();
?>
