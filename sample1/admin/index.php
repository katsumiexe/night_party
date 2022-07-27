<?
include_once('../library/sql_admin.php');
include_once('../library/inc_code.php');

/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$staff_set	=$_POST["staff_set"];//１新規　２変更　３キャスト追加変更　４削除
$staff_id	=$_POST["staff_id"];
$menu_post	=$_POST["menu_post"];

$prm=$_POST["prm"];

if($prm == "1"){
	$post_id	="event";
	$menu_post	="contents";

}else if($prm == "2"){
	$menu_post	="config";

}else if($prm == "3"){
	$menu_post	="staff";

}else if($prm == "4"){
	$menu_post	="sche";

}else if($prm == "5"){
	$menu_post	="blog";

}else if($prm == "6"){
	$menu_post	="contact";
}


//■スタッフブログ
if($menu_post == "blog_write"){
	$writer		=$_POST["writer"];
	$view_date	=str_replace("T"," ",$_POST["view_date"].":00");
	$status		=$_POST["status"];
	$title		=$_POST["title"];
	$tag		=$_POST["tag"];
	$news_check	=$_POST["news_check"];
	$log		=$_POST["log"];
	$img_code	=$_POST["img_code"];

	if(!$title){
		$title="無題";
	}

	if($img_code){

		$img_name	 =time()+2121212121;
		$img_name	 ="p".$img_name;

		$img_link="../img/profile/{$writer}/{$img_name}";

		$img	= imagecreatefromstring(base64_decode($img_code));	
		$img2	= imagecreatetruecolor(600,600);
		ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);

		imagepng($img2,$img_link.".png");

		if($admin_config["webp_select"] == 1){
//			imagewebp($img2,$img_link.".webp");
		}

		$img2	= imagecreatetruecolor(300,300);
		ImageCopyResampled($img2, $img, 0, 0, 0, 0, 300, 300, 600, 600);
		imagepng($img2,$img_link."_s.png");

		if($admin_config["webp_select"] == 1){
//			imagewebp($img2,$img_link."_s.webp");
		}
		imagedestroy($img2);
	}

	$sql="INSERT INTO ".TABLE_KEY."_posts ";
	$sql.="(`date`, `view_date`, `title`, `log`, `cast`, `tag`, `img`, `status`,`prm`)";
	$sql.="VALUES";
	$sql.="('{$now}','{$view_date}','{$title}','{$log}','{$writer}','{$tag}','{$img_name}','{$status}','0')";
//	mysqli_query($mysqli,$sql);
//	$tmp_auto=mysqli_insert_id($mysqli); 

	if($_POST["news_check"] == 1){
		$sql	 ="INSERT INTO ".TABLE_KEY."_contents(`date`,`display_date`,`event_date`,`sort`,`page`,`category`,`title`,`contents_key`,`tag`,`status`,`prm`)";
		$sql	.=" VALUES('{$now}','{$view_date}','{$view_date}','0','news','blog','{$title}','{$tmp_auto}','11','{$status}','0')";
		mysqli_query($mysqli,$sql);
	}
	$menu_post ="blog";
}

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

	$st_top			=$_POST["st_top"];
	$st_left		=$_POST["st_left"];
	$st_width		=$_POST["st_width"];
	$st_height		=$_POST["st_height"];

	if(!$staff_registday) $staff_registday=date("Ymd");
	$btime=str_replace("-","",$b_date);


	if($cast_status ==5){
		$sql  =" UPDATE ".TABLE_KEY."_staff SET";
		$sql .=" `del`=1";
		$sql .=" WHERE staff_id='{$_POST["staff_id"]}'";
//		mysqli_query($mysqli,$sql);

	}elseif($staff_set == 2 || $staff_set == 3){


		$sql="UPDATE ".TABLE_KEY."_staff SET";
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
//		mysqli_query($mysqli,$sql);


	//新規STAFF
	}else{
		$sql="INSERT INTO ".TABLE_KEY."_staff (`name`,`kana`,`birthday`,`sex`,`rank`,`position`,`group`,`tel`,`line`,`mail`,`address`,`registday`,`del`)";
		$sql.="VALUES('{$staff_name}','{$staff_kana}','{$btime}','{$staff_sex}','{$staff_rank}','{$staff_position}','{$staff_group}','{$staff_tel}','{$staff_line}','{$staff_mail}','{$staff_address}','{$staff_registday}','0')";
//		mysqli_query($mysqli,$sql);
		$staff_id=mysqli_insert_id($mysqli);
	}
//■cast-------------------------------

	if($c_s == 0){

		$ctime=str_replace("-","",$c_date);

		$sql ="SELECT regist_id FROM ".TABLE_KEY."_cast";
		$sql.=" WHERE id='{$staff_id}'";
		$sql.=" LIMIT 1";
		$result = mysqli_query($mysqli,$sql);
		$row = mysqli_fetch_assoc($result);

		if($row["regist_id"] >0){//変更
			$sql="UPDATE ".TABLE_KEY."_cast SET";
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

			$sql="DELETE FROM ".TABLE_KEY."_check_sel WHERE cast_id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

			$sql="DELETE FROM ".TABLE_KEY."_charm_sel WHERE cast_id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

		}else{//新規１　かCAST追加3
			$sql="INSERT INTO ".TABLE_KEY."_cast (`id`,`genji`,`genji_kana`,`login_id`,`login_pass`,`cast_mail`,`cast_status`,`ctime`,`cast_sort`,`cast_salary`,`ribbon_use`,`cast_ribbon`,`del`)";
			$sql.="VALUES('{$staff_id}','{$genji}','{$genji_kana}','{$cast_id}','{$cast_pass}','{$cast_mail}','0','{$ctime}','0','{$cast_salary}','{$ribbon_use}','{$cast_ribbon}',0)";
//			mysqli_query($mysqli,$sql);

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

			$sql="INSERT INTO ".TABLE_KEY."_cast_log_table(cast_id,item_name,item_icon,item_color,price,sort,del)VALUES";
			$sql.="('{$staff_id}','ドリンクA','0','48','100','1','0'),";
			$sql.="('{$staff_id}','ドリンクB','2','35','200','2','0'),";
			$sql.="('{$staff_id}','フードA','4','3','300','3','0'),";
			$sql.="('{$staff_id}','フードB','5','7','500','4','0'),";
			$sql.="('{$staff_id}','ボトル','3','36','1000','5','0'),";	
			$sql.="('{$staff_id}','本指名','8','55','1000','6','0'),";
			$sql.="('{$staff_id}','場内指名','8','12','500','7','0'),";
			$sql.="('{$staff_id}','同伴','6','59','2000','8','0')";
//			mysqli_query($mysqli,$sql);


			$sql="INSERT INTO ".TABLE_KEY."_easytalk_tmpl(cast_id,sort,title,log)VALUES";
			$sql.="('{$staff_id}',0,'テンプレート01','[呼び名]さん\nこんにちは！　昨日は来てくれてありがとう！\nまた楽しい話を聞かせてくださいね。\n'),";
			$sql.="('{$staff_id}',1,'テンプレート02','こんにちは！\nお元気していますか？\n実は今週末は私の誕生日なんです！\nつきましては、誕生日イベントを行うので、[呼び名]さんも来てくれたら嬉しいです！\nぜひ、お待ちしておりますね♪\n'),";
			$sql.="('{$staff_id}',2,'テンプレート03','[呼び名]さん\n\nHappy Birthday!!\n(ﾉ∀`)っ由”\n'),";
			$sql.="('{$staff_id}',3,'テンプレート04','[呼び名]さんっ！　こんにちは！\n久しぶりだけど元気してます～？\n\nお仕事疲れたと時はまたいつでも遊びに来てくださいね♪\nたまにはリフレッシュも大事だよ\n'),";
			$sql.="('{$staff_id}',4,'テンプレート05','出勤前にぼーっとしてたら、[呼び名]さんにメールしたくなっちゃいました♡\n今日も、お仕事お疲れ様ですm(_ _)m。\nお仕事中、メールしちゃってごめんなさい\nまた会いに来てくれたらうれしいな♪\n')";
//			mysqli_query($mysqli,$sql);

			if($_REQUEST["news_date_c"] && $_REQUEST["news_box"]){
				$title=str_replace("[name]","<span style=\"color:#ffffff; font-weight:600\">{$genji}</span>",$_REQUEST["news_box"]);
				$p_date=$_REQUEST["news_date_c"]." 00:00:00";
				$sql =" INSERT INTO ".TABLE_KEY."_contents";
				$sql .="(`date`, display_date, event_date, page, category, contents_key, title, contents,`tag`,`sort`,`status`)";
				$sql .=" VALUES('{$now}','{$p_date}','{$c_date}','news','person','{$staff_id}','{$title}','{$news_box}','12','0','0')";
//				mysqli_query($mysqli,$sql);
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
			$sql="INSERT INTO ".TABLE_KEY."_check_sel(list_id,cast_id,sel)VALUES";
			$sql.=$app;
//			mysqli_query($mysqli,$sql);
		}

//■charm_table-------------------------------
		foreach($charm_table as $a1 => $a2){
			if($a2){
				$app2.="('{$a1}','{$staff_id}','{$a2}'),";
			}
		}
		if($app2){
			$app2=substr($app2,0,-1);
			$sql="INSERT INTO ".TABLE_KEY."_charm_sel(list_id,cast_id,log)VALUES";
			$sql.=$app2;
//			mysqli_query($mysqli,$sql);
		}

//■img-------------------------------
		if($img_c){
			$link="../img/profile/".$staff_id;
			$stamp_url="../img/stamp/stamp_0.png";

			foreach($img_c as $a1 => $a2){
				if($a2 =="334"){
					unlink($link."/".$a1.".jpg");
					unlink($link."/".$a1.".webp");
					unlink($link."/".$a1."_s.jpg");
					unlink($link."/".$a1."_s.webp");

				}elseif($a2 || $st_top[$a1]>0){
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

					$img2_s 		= imagecreatetruecolor(300,400);
					ImageCopyResampled($img2_s, $img, 0, 0, $tmp_left, $tmp_top, 300, 400, $tmp_width, $tmp_height);

					$img2_n 		= imagecreatetruecolor(150,200);
					ImageCopyResampled($img2_n, $img, 0, 0, $tmp_left, $tmp_top, 150, 200, $tmp_width, $tmp_height);

					if($st_top[$a1]>0){
						$top	=ceil(($st_top[$a1]-20)*(600 / 150));
						$left	=ceil(($st_left[$a1]-20)*(600 / 150));
						$width	=ceil($st_width[$a1]*(600 / 150));
						$height	=ceil($st_height[$a1]*(600 / 150));

						$top_s		=ceil(($st_top[$a1]-20)*(300 / 150));
						$left_s		=ceil(($st_left[$a1]-20)*(300 / 150));
						$width_s	=ceil($st_width[$a1]*(300 / 150));
						$height_s	=ceil($st_height[$a1]*(300 / 150));

						$top_n		=$st_top[$a1]-20;
						$left_n		=$st_left[$a1]-20;
						$width_n	=$st_width[$a1];
						$height_n	=$st_height[$a1];

						$stamp_img	= imagecreatefrompng($stamp_url);	
						imagealphablending($stamp_img, false);
						imagesavealpha($stamp_img, true);
						$top2	=85;
						$left2	=85;
						ImageCopyResampled($img2, $stamp_img, $left, $top, $left2, $top2, $width, $height, 430, 430);
						ImageCopyResampled($img2_s, $stamp_img, $left_s, $top_s, $left2, $top2, $width_s, $height_s, 430, 430);
						ImageCopyResampled($img2_n, $stamp_img, $left_n, $top_n, $left2, $top2, $width_n, $height_n, 430, 430);
					}

//					imagejpeg($img2,$link."/".$a1.".jpg",100);
//					imagejpeg($img2_s,$link."/".$a1."_s.jpg",100);
//					imagejpeg($img2_n,$link."/".$a1."_n.jpg",100);

if($admin_config["webp_select"] == 1){
//					imagewebp($img2,$link."/".$a1.".webp");
//					imagewebp($img2_s,$link."/".$a1."_s.webp");
//					imagewebp($img2_n,$link."/".$a1."_n.webp");
}
					imagedestroy($img2);
					imagedestroy($img2_s);
					imagedestroy($img2_n);

				}
			}
		}
	}else{
		$sql="UPDATE ".TABLE_KEY."_cast SET";
		$sql.=" `del`='{$c_s}'";
		$sql.=" WHERE id='{$staff_id}'";
//		mysqli_query($mysqli,$sql);
	}

}elseif($_POST["prof_name_new"] && $_POST["prof_style_new"]){
	$menu_post="staff";
	$sql="INSERT INTO ".TABLE_KEY."_charm_table (`charm`,`sort`,`style`,`del`)";
	$sql.="VALUES('{$_POST["prof_name_new"]}','{$_POST["prof_sort_new"]}','{$_POST["prof_style_new"]},`0`')";
//	mysqli_query($mysqli,$sql);

}elseif($_POST["tag_name_new"]){
	if(!$_POST["tag_color_new"]){
		$_POST["tag_color_new"]="#c0a060";
	}

	$st=0;	
	$sql="SELECT id,sort FROM ".TABLE_KEY."_tag";
	$sql.=" WHERE tag_group='news'";
	$sql.=" ORDER BY sort ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$sql =" UPDATE ".TABLE_KEY."_tag SET";
			$sql.=" sort='{$st}'";
			$sql.=" WHERE id='{$row["id"]}'";
//			mysqli_query($mysqli,$sql);
		}
		$st++;
	}
	$sql	 ="INSERT INTO ".TABLE_KEY."_charm_table (`tag_group`,`sort`,`tag_name`,`tag_icon`,`del`)";
	$sql	.="VALUES('news','{$st}','{$_POST["tag_name_new"]}','{$_POST["tag_color_new"]}','0')";
//	mysqli_query($mysqli,$sql);

}elseif($_POST["option_new_title"]){

	$sql="INSERT INTO  `".TABLE_KEY."_check_main`(`title`,`style`,`del`)";
	$sql.=" VALUES('{$_POST["option_new_title"]}','{$_POST["option_new_select"]}','0')";
//	mysqli_query($mysqli,$sql);
//	$tmp_auto=mysqli_insert_id($mysqli);

	$sql="UPDATE `".TABLE_KEY."_check_main` SET";
	$sql.=" sort='{$tmp_auto}'";
//	mysqli_query($mysqli,$sql);
}
if(!$menu_post) $menu_post="staff";
$sel[$menu_post]="menu_sel";
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="../js/jquery.ui.touch-punch.min.js>"></script>
<script src="./js/admin.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/admin.css">

<style>
@font-face {
	font-family: at_icon;
	src: url("../font/nightparty_icon.ttf") format('truetype');
}
.menu_sel{
	background:linear-gradient(#ff0000,#e00000);
	color:#fafafa;
}
.wait{
	display			:none;
	position		:fixed;
	top				:-10vh;
	left			:-10vw;
	width			:120vw;
	height			:120vh;
	background		:rgba(30,30,30,0.7);
	z-index			:201;
}

.wait_in{
	position		:absolute;
	top				:0;
	left			:0;
	right			:0;
	bottom			:0;
	margin			:auto;
	width			:100px;
	height			:100px;
	border-top		:10px solid #777777;
	border-left		:10px solid #0000d0;
	border-right	:10px solid #0000d0;
	border-bottom	:10px solid #0000d0;
	border-radius	:50%;
	animation		:3s linear infinite wait_animation;
}
@keyframes wait_animation{
	0%{ transform:rotate(0);}
	100%{ transform:rotate(360deg); }
}

.admin_login{
	margin		:50px auto 5 auto;
	background	:#fafafa;
	border		:1px solid #202020;
	border-radius:3px;
	text-align	:center;
}

.admin_login_1{
	position	:relative;
	height		:50px;
	width		:300px;
	text-align	:center;
}

.admin_login_1_in{
	position	:absolute;
	left		:0;
	right		:0;
	bottom		:5px;
	margin		:auto;
	font-size	:20px;
	font-weight	:800;
}

.admin_login_tag{
	display		:block;
	width		:250px;
	text-align	:left;
	padding-left:5px;
	font-size	:15px;
	margin		:5px auto 0 auto;
}

.admin_login_box{
	width		:250px;
	text-align	:left;
	padding-left:5px;
	font-size	:20px !important;
	height		:40px !important;
	margin		:0 auto 10px auto;
}

.admin_login_btn{
	width		:250px;
	text-align	:center;
	height		:40px;
	line-height	:40px;
	margin		:10px auto;
	font-size	:24px;
	font-weight	:700;
	background	:linear-gradient(#c0c0ff,#a0a0ff);
	color		:#fafafa;
}

.admin_login_chg{
	display		:inline-block;
	margin		:10px 25px;
	padding		:2px;
	border-bottom:1px solid #303030;
	cursor		:pointer;
	width		:196px;
	text-align	:center;"
}

.err_msg{
	font-weight	:700;
	font-size	:16px;
	color		:#c00000;
	text-align	:center;
	margin		:0 auto;
}

.caution{
	margin		:10px auto;
	border		:1px solid #ff3030;
	padding		:5px;
	font-size	:13px;
	line-height	:19px;
	background	:#fafafa;
	color		:#606060;
	width		:160px;
	text-align	:left;
}
</style>
</head>
<body class="body">
<div id="wait" class="wait">
	<div class="wait_in"></div>
</div>

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
		<li id="blog" class="menu <?=$sel["blog"]?>"><span class="menu_icon"></span><span class="menu_comm">ブログ</span></li>
		<li id="blogset" class="menu <?=$sel["blogset"]?>"><span class="menu_icon"></span><span class="menu_comm">ブログ投稿</span></li>
		<li id="contact" class="menu <?=$sel["contact"]?>"><span class="menu_icon"></span><span class="menu_comm">お問合せ</span></li>
		<li id="logout" class="menu"><span class="menu_icon"></span><span class="menu_comm">LOG OUT</span></li>
	</ul>
	<div class="caution">
	※操作は可能ですが、データの新規登録、変更は出来ません。
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

	<div class="b_img_box">
		<div class="b_img_box_in">
			<canvas id="cvs1" width="1800" height="1800"></canvas>
			<div class="b_img_box_out1"></div>
			<div class="b_img_box_out2"></div>
			<div class="b_img_box_out3"></div>
			<div class="b_img_box_out4"></div>
			<div class="b_img_box_out5"></div>
			<div class="b_img_box_out6"></div>
			<div class="b_img_box_out7"></div>
			<div class="b_img_box_out8"></div>

			<?for($n=0;$n<10;$n++){?>
				<?$n1=$n*10+25?>
				<div id="stamp3<?=$n?>" class="b_img_stamp" style="z-index:3<?=$n?>;top:<?=$n1?>px;left:<?=$n1?>px;">
				<img class="b_img_stamp_in">
				<span class="b_img_ctrl b_stamp_r"></span>
				<span class="b_img_ctrl b_stamp_d"></span>
				</div>
				<input type="hidden" id="b_rote3<?=$n?>" class="b_stamp_rote">
			<? } ?>
		</div>

		<div class="b_img_box_in2">
			<label for="upd" class="upload_btn"><span class="upload_icon_p"></span><span class="upload_txt">画像選択</span></label>
			<span class="upload_icon upload_rote"></span>
			<span class="upload_icon upload_trush"></span>
			<span class="upload_icon upload_stamp"></span>
		</div>

		<div class="b_img_box_in3">
			<div class="b_zoom_mi">-</div>
			<div class="b_zoom_rg"><input id="b_input_zoom" type="range" name="num" min="100" max="300" step="1" value="100" class="b_range_bar"></div>
			<div class="b_zoom_pu">+</div><div class="b_zoom_box">100</div>
		</div>
		<div class="b_img_box_in4">
			<div id="img_set" class="btn btn_c5">登録</div>　
			<div id="img_close" class="btn btn_c4">戻る</div>　
			<div id="img_reset" class="btn btn_c6">リセット</div>
		</div>

		<table class="b_stamp_box">
			<tr>
			<td id="stamp_in0" class="b_stamp_box_in"><img src="../img/stamp/stamp_0.png" class="b_stamp_box_img"></td>
			<td id="stamp_in1" class="b_stamp_box_in"><img src="../img/stamp/stamp_1.png" class="b_stamp_box_img"></td>
			<td id="stamp_in2" class="b_stamp_box_in"><img src="../img/stamp/stamp_2.png" class="b_stamp_box_img"></td>
			<td id="stamp_in3" class="b_stamp_box_in"><img src="../img/stamp/stamp_3.png" class="b_stamp_box_img"></td>
			<td id="stamp_in4" class="b_stamp_box_in"><img src="../img/stamp/stamp_4.png" class="b_stamp_box_img"></td>
			<td id="stamp_in5" class="b_stamp_box_in"><img src="../img/stamp/stamp_5.png" class="b_stamp_box_img"></td>
			<td id="stamp_in6" class="b_stamp_box_in"><img src="../img/stamp/stamp_6.png" class="b_stamp_box_img"></td>
			<td id="stamp_in7" class="b_stamp_box_in"><img src="../img/stamp/stamp_7.png" class="b_stamp_box_img"></td>
			</tr>
		</table>

		<div class="b_stamp_config">
			<div class="b_stamp_config_0">半透明</div>
			<img src id="st_0" class="b_stamp_config_4">
			<div id="st_1" class="b_stamp_config_3"><span class="b_stamp_config_icon"></span>前面</div>
			<div id="st_2" class="b_stamp_config_3"><span class="b_stamp_config_icon"></span>最前面</div>
			<div id="st_3" class="b_stamp_config_3"><span class="b_stamp_config_icon"></span>背面</div>
			<div id="st_4" class="b_stamp_config_3"><span class="b_stamp_config_icon"></span>最背面</div>
			<div id="st_5" class="b_stamp_config_2"><span class="b_stamp_config_icon"></span>リセット</div>
			<div id="st_6" class="b_stamp_config_1"><span class="b_stamp_config_icon"></span>削除</div>
		</div>
		<input id="upd" type="file" accept="image/*" style="display:none;">
	</div>
</div>
</body>
</html>