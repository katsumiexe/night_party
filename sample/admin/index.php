<?
include_once('../library/sql_admin.php');
include_once('../library/inc_code.php');

/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

/*
#d0d0ff 
#e6e6fa
*/

$staff_set	=$_POST["staff_set"];//１新規　２変更　３キャスト追加変更　４削除

$staff_id	=$_POST["staff_id"];
$menu_post	=$_POST["menu_post"];

//■スタッフ登録or変更

if($staff_set){
	$menu_post="staff";
	$c_s			=$_POST["c_s"];
	$staff_name		=$_POST["staff_name"];
	$staff_kana		=$_POST["staff_kana"];
	$staff_birthday	=$_POST["staff_birthday"];
	$staff_sex		=$_POST["staff_sex"];
	$staff_rank		=$_POST["staff_rank"]+0;
	$staff_position	=$_POST["staff_position"];
	$staff_group	=$_POST["staff_group"];
	$staff_tel		=$_POST["staff_tel"];
	$staff_line		=$_POST["staff_line"];
	$staff_mail		=$_POST["staff_mail"];
	$staff_address	=$_POST["staff_address"];
	$staff_registday=$_POST["staff_registday"];

	$b_date			=$_POST["b_date"];

	$cast_status	=$_POST["cast_status"]+0;
	$cast_id		=$_POST["cast_id"];
	$cast_pass		=$_POST["cast_pass"];
	$genji			=$_POST["genji"];
	$genji_kana		=$_POST["genji_kana"];
	$cast_mail		=$_POST["cast_mail"];

	$ribbon_use		=$_POST["ribbon_use"]+0;
	$cast_ribbon	=$_POST["cast_ribbon"]+0;
	$prm			=$_POST["prm"]+1;


	$c_date			=$_POST["c_date"];

	$cast_rank		=$_POST["cast_rank"]+0;
	$cast_sort		=$_POST["cast_sort"]+0;

	$cast_salary	=$_POST["cast_salary"]+0;
	$charm_table	=$_POST["charm_table"];
	$options		=$_POST["options"];

	$img_c			=$_POST["img_c"];
	$img_w			=$_POST["img_w"];
	$img_h			=$_POST["img_h"];
	$img_x			=$_POST["img_x"];
	$img_y			=$_POST["img_y"];
	$img_z			=$_POST["img_z"];
	$img_r			=$_POST["img_r"];
	$img_v			=$_POST["img_v"];

	if(!$staff_registday) $staff_registday=date("Ymd");
	$btime=str_replace("-","",$b_date);


	if($cast_status ==5){
		$sql  =" UPDATE wp00000_staff SET";
		$sql .=" `del`=1";
		$sql .=" WHERE staff_id='{$_POST["staff_id"]}'";
		mysqli_query($mysqli,$sql);

	}elseif($staff_set == 2 || $staff_set == 3){


		$sql="UPDATE wp00000_staff SET";
		$sql.=" `name`='{$staff_name}',";
		$sql.=" `kana`='{$staff_kana}',";
		$sql.=" `birthday`='{$btime}',";
		$sql.=" `sex`='{$staff_sex}',";
		$sql.=" `rank`='{$staff_rank}',";
		$sql.=" `position`='{$staff_position}',";
		$sql.=" `group`='{$staff_group}',";
		$sql.=" `tel`='{$staff_tel}',";
		$sql.=" `line`='{$staff_line}',";
		$sql.=" `mail`='{$staff_mail}',";
		$sql.=" `address`='{$staff_address}',";
		$sql.=" `registday`='{$staff_registday}'";
		$sql.=" WHERE staff_id='{$staff_id}'";
		mysqli_query($mysqli,$sql);


	//新規STAFF
	}else{
		$sql="INSERT INTO wp00000_staff (`name`,`kana`,`birthday`,`sex`,`rank`,`position`,`group`,`tel`,`line`,`mail`,`address`,`registday`,`del`)";
		$sql.="VALUES('{$staff_name}','{$staff_kana}','{$btime}','{$staff_sex}','{$staff_rank}','{$staff_position}','{$staff_group}','{$staff_tel}','{$staff_line}','{$staff_mail}','{$staff_address}','{$staff_registday}','0')";
		mysqli_query($mysqli,$sql);
		$staff_id=mysqli_insert_id($mysqli);
	}
//■cast-------------------------------

	if($c_s == 0){

		$ctime=str_replace("-","",$c_date);

		$sql ="SELECT regist_id FROM wp00000_cast";
		$sql.=" WHERE id='{$staff_id}'";
		$sql.=" LIMIT 1";
		$result = mysqli_query($mysqli,$sql);
		$row = mysqli_fetch_assoc($result);
	
			
		if($row["regist_id"] >0){//変更
			$sql="UPDATE wp00000_cast SET";
			$sql.=" `genji`='{$genji}',";
			$sql.=" `genji_kana`='{$genji_kana}',";

			$sql.=" `login_id`='{$cast_id}',";
			$sql.=" `login_pass`='{$cast_pass}',";
			$sql.=" `cast_mail`='{$cast_mail}',";
			$sql.=" `cast_status`='{$cast_status}',";
			$sql.=" `ctime`='{$ctime}',";
			$sql.=" `cast_rank`='{$cast_rank}',";
			$sql.=" `cast_salary`='{$cast_salary}',";
			$sql.=" `del`='{$c_s}',";
			$sql.=" `prm`='{$prm}',";
			$sql.=" `cast_ribbon`='{$cast_ribbon}'";
			$sql.=" WHERE id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

			$sql="DELETE FROM wp00000_check_sel WHERE cast_id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

			$sql="DELETE FROM wp00000_charm_sel WHERE cast_id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

		}else{//新規１　かCAST追加3
			$sql="INSERT INTO wp00000_cast (`id`,`genji`,`genji_kana`,`login_id`,`login_pass`,`cast_mail`,`cast_status`,`ctime`,`cast_sort`,`cast_salary`,`ribbon_use`,`cast_ribbon`,`del`)";
			$sql.="VALUES('{$staff_id}','{$genji}','{$genji_kana}','{$cast_id}','{$cast_pass}','{$cast_mail}','0','{$ctime}','0','{$cast_salary}','{$ribbon_use}','{$cast_ribbon}',0)";
			mysqli_query($mysqli,$sql);

//■encode-------------------------------
			$id_8	=substr("00000000".$staff_id,-8);
			$id_0	=$staff_id % 20;
			for($n=0;$n<8;$n++){
				$tmp_id=substr($id_8,$n,1);
				$tmp_dir.=$dec[$id_0][$tmp_id];
			}
			$tmp_dir.=$id_0;

			$mk_dir="../img/cast/".$tmp_dir;
			if(!is_dir($mk_dir)) {
				mkdir($mk_dir."/c/", 0777, TRUE);
				chmod($mk_dir."/c/", 0777);

				mkdir($mk_dir."/m/", 0777, TRUE);
				chmod($mk_dir."/m/", 0777);
			}

			$link="../img/profile/".$staff_id;
			if(!is_dir($link)) {
				mkdir($link, 0777, TRUE);
				chmod($link, 0777);
			}

			$sql="INSERT INTO wp00000_cast_log_table(cast_id,item_name,item_icon,item_color,price,sort,del)VALUES";
			$sql.="('{$staff_id}','ドリンクA','0','48','100','0','0'),";
			$sql.="('{$staff_id}','ドリンクB','2','35','200','1','0'),";
			$sql.="('{$staff_id}','フードA','4','3','300','2','0'),";
			$sql.="('{$staff_id}','フードB','5','7','500','3','0'),";
			$sql.="('{$staff_id}','ボトル','3','36','1000','4','0'),";	
			$sql.="('{$staff_id}','本指名','8','55','1000','5','0'),";
			$sql.="('{$staff_id}','場内指名','8','12','500','6','0'),";
			$sql.="('{$staff_id}','同伴','6','59','2000','7,'0'')";
			mysqli_query($mysqli,$sql);

			$sql="INSERT INTO wp00000_easytalk_tmpl(cast_id,sort,title,log)VALUES";
			$sql.="('{$staff_id}',0,'テンプレート01','[名前]様\nこんにちは！　昨日は来てくれてありがとう！\nまた楽しい話を聞かせてくださいね。\n'),";
			$sql.="('{$staff_id}',1,'テンプレート02','こんにちは！\nお元気していますか？\n実は今週末は私の誕生日なんです！\nつきましては、誕生日イベントを行うので、[呼び名]さんも来てくれたら嬉しいです！\nぜひ、お待ちしておりますね♪\n'),";
			$sql.="('{$staff_id}',2,'テンプレート03','[呼び名]さん\n\nHappy Birthday!!\n(ﾉ∀`)っ由”\n'),";
			$sql.="('{$staff_id}',3,'テンプレート04','[呼び名]さんっ！　こんにちは！\n久しぶりだけど元気してます～？\n\nお仕事疲れたと時はまたいつでも遊びに来てくださいね♪\nたまにはリフレッシュも大事だよ\n'),";
			$sql.="('{$staff_id}',4,'テンプレート05','出勤前にぼーっとしてたら、[呼び名]さんに✉したくなっちゃいました♡\n今日も、お仕事お疲れ様ですm(_ _)m。\nお仕事中、メールしちゃってごめんなさい\nまた会いに来てくれたらうれしいな♪\n')";
			mysqli_query($mysqli,$sql);


			if($_REQUEST["news_date_c"] && $_REQUEST["news_box"]){
				$title=str_replace("[name]","<span style=\"color:#ffffff; font-weight:600\">{$genji}</span>",$_REQUEST["news_box"]);
				$p_date=$_REQUEST["news_date_c"]." 00:00:00";
				$sql =" INSERT INTO wp00000_contents";
				$sql .="(`date`, display_date, event_date, page, category, contents_key, title, contents,`tag`,`sort`,`status`)";
				$sql .=" VALUES('{$now}','{$p_date}','{$c_date}','news','person','{$staff_id}','{$title}','{$news_box}','12','0','0')";
				mysqli_query($mysqli,$sql);
			}
		}
			
//■options-------------------------------
		foreach($options as $a1 => $a2){
			if($a2 == "on"){
				$app.="('{$a1}','{$staff_id}',1),";
			}
		}
		if($app){
			$app=substr($app,0,-1);
			$sql="INSERT INTO wp00000_check_sel(list_id,cast_id,sel)VALUES";
			$sql.=$app;
			mysqli_query($mysqli,$sql);
		}

//■charm_table-------------------------------
		foreach($charm_table as $a1 => $a2){
			if($a2){
				$app2.="('{$a1}','{$staff_id}','{$a2}'),";
			}
		}
		if($app2){
			$app2=substr($app2,0,-1);
			$sql="INSERT INTO wp00000_charm_sel(list_id,cast_id,log)VALUES";
			$sql.=$app2;
			mysqli_query($mysqli,$sql);
		}

//■img-------------------------------
		if($img_c){
			$link="../img/profile/".$staff_id;
			foreach($img_c as $a1 => $a2){
				if($a2 =="334"){

					unlink($link."/".$a1.".jpg");
					unlink($link."/".$a1.".webp");
					unlink($link."/".$a1."_s.jpg");
					unlink($link."/".$a1."_s.webp");

				}elseif($a2){
					$tmp_width	=ceil( ( 150 / $img_v[$a1] ) * ( 100 / $img_z[$a1] ) );
					$tmp_height	=ceil( ( 200 / $img_v[$a1] ) * ( 100 / $img_z[$a1] ) );

					$tmp_left	=floor( ($img_x[$a1] - 20 ) / $img_v[$a1] * ( -100 / $img_z[$a1] ) );
					$tmp_top	=floor( ($img_y[$a1] - 20 ) / $img_v[$a1] * ( -100 / $img_z[$a1] ) );


					if($img_r[$a1] ==90){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));	
						$img		= imagerotate($new_img, 270, 0, 0);

					}elseif($img_r[$a1] ==180){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));	
						$img		= imagerotate($new_img, 180, 0, 0);

					}elseif($img_r[$a1] ==270){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));
						$img		= imagerotate($new_img, 90, 0, 0);

					}else{
						$img = imagecreatefromstring(base64_decode($img_c[$a1]));
					}

					$img2 		= imagecreatetruecolor(600,800);
					ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, 600, 800, $tmp_width, $tmp_height);

					imagejpeg($img2,$link."/".$a1.".jpg",100);
if($admin_config["webp_select"] == 1){
					imagewebp($img2,$link."/".$a1.".webp");
}
					imagedestroy($img2);



					$img2_s 		= imagecreatetruecolor(300,400);
					ImageCopyResampled($img2_s, $img, 0, 0, $tmp_left, $tmp_top, 300, 400, $tmp_width, $tmp_height);

					imagejpeg($img2_s,$link."/".$a1."_s.jpg",100);
if($admin_config["webp_select"] == 1){
					imagewebp($img2_s,$link."/".$a1."_s.webp");
}
					imagedestroy($img2_s);

					$img2_n 		= imagecreatetruecolor(30,40);
					ImageCopyResampled($img2_n, $img, 0, 0, $tmp_left, $tmp_top, 30, 40, $tmp_width, $tmp_height);
					imagejpeg($img2_n,$link."/".$a1."_n.jpg",100);
					imagedestroy($img2_n);
				}
			}
		}
	}else{
		$sql="UPDATE wp00000_cast SET";
		$sql.=" `del`='{$c_s}'";
		$sql.=" WHERE id='{$staff_id}'";
		mysqli_query($mysqli,$sql);
	}

}elseif($_POST["prof_name_new"] && $_POST["prof_style_new"]){
	$menu_post="staff";
	$sql="INSERT INTO wp00000_charm_table (`charm`,`sort`,`style`,`del`)";
	$sql.="VALUES('{$_POST["prof_name_new"]}','{$_POST["prof_sort_new"]}','{$_POST["prof_style_new"]},`0`')";
	mysqli_query($mysqli,$sql);

}elseif($_POST["tag_name_new"]){
	if(!$_POST["tag_color_new"]){
		$_POST["tag_color_new"]="#c0a060";
	}

	$st=0;	
	$sql="SELECT id,sort FROM wp00000_tag";
	$sql.=" WHERE tag_group='news'";
	$sql.=" ORDER BY sort ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$sql =" UPDATE wp00000_tag SET";
			$sql.=" sort='{$st}'";
			$sql.=" WHERE id='{$row["id"]}'";
			mysqli_query($mysqli,$sql);
		}
		$st++;
	}
	$sql	 ="INSERT INTO wp00000_charm_table (`tag_group`,`sort`,`tag_name`,`tag_icon`,`del`)";
	$sql	.="VALUES('news','{$st}','{$_POST["tag_name_new"]}','{$_POST["tag_color_new"]}','0')";
	mysqli_query($mysqli,$sql);

}elseif($_POST["option_new_title"]){

	$sql="INSERT INTO  `wp00000_check_main`(`title`,`style`,`del`)";
	$sql.=" VALUES('{$_POST["option_new_title"]}','{$_POST["option_new_select"]}','0')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);

	$sql="UPDATE `wp00000_check_main` SET";
	$sql.=" sort='{$tmp_auto}'";
	mysqli_query($mysqli,$sql);
}

if(!$menu_post) $menu_post="staff";
$sel[$menu_post]="menu_sel";

?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="../js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="./js/admin.js?t=<?=time()?>"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/admin.css?t=<?=time()?>">

<style>
/*
@font-face {
	font-family: at_icon;
	src: url("../font/font_0/fonts/icomoon.ttf") format('truetype');
}

@font-face {
	font-family: at_frame1;
	src: url("../font/font_3/fonts/icomoon.ttf") format('truetype');
}

@font-face {
	font-family: at_frame2;
	src: url("../font/border/frame2.ttf") format('truetype');
}

@font-face {
	font-family: at_font1;
	src: url("../font/Courgette-Regular.ttf") format('truetype');
}
*/

@font-face {
	font-family: at_icon;
	src: url("../font/nightparty_icon.ttf") format('truetype');
}


.menu_sel{
	background:linear-gradient(#ff0000,#e00000);
	color:#fafafa;
}
</style>
</head>

<body class="body">
<div class="main">
	<?if($menu_post){?>
		<?include_once("./admin_{$menu_post}.php");?>
	<?}?>
</div>
<div class="left">
	<ul class="menu_ul">
		<li id="regist" class="menu <?=$sel["regist"]?>"><span class="menu_icon"></span><span class="menu_comm">登録</span></li>
		<li id="staff" class="menu <?=$sel["staff"]?> <?=$sel["staff_fix"]?>"><span class="menu_icon"></span><span class="menu_comm">スタッフ</span></li>
		<li id="sche" class="menu <?=$sel["sche"]?>"><span class="menu_icon"></span><span class="menu_comm">スケジュール</span></li>
		<li id="contents" class="menu <?=$sel["contents"]?>"><span class="menu_icon"></span><span class="menu_comm">コンテンツ</span></li>
		<li id="notice" class="menu <?=$sel["notice"]?>"><span class="menu_icon"></span><span class="menu_comm">お知らせ</span></li>
		<li id="config" class="menu <?=$sel["config"]?>"><span class="menu_icon"></span><span class="menu_comm">設定</span></li>
		<li id="blog" class="menu <?=$sel["blog"]?>"><span class="menu_icon"></span><span class="menu_comm">ブログ</span></li>
		<li id="contact" class="menu <?=$sel["contact"]?>"><span class="menu_icon"></span><span class="menu_comm">お問合せ</span></li>
	</ul>
	<div class="head_menu">
		<div class="menu_a"></div>
		<div class="menu_b"></div>
		<div class="menu_c"></div>
	</div>
</div>
<form id="form_menu" method="post" action="./index.php">
<input id="menu_post" type="hidden" name="menu_post">
</form>

<div class="back">
<div class="pop">
<div class="pop_out">×</div>
<div class="pop_msg"></div>
<button id="pop_ok" type="button" class="pop_btn">送信</button>
<button id="pop_ng" type="button" class="pop_btn">取消</button>
</div>
</div>
</html>
