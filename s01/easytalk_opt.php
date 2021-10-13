<?php
include_once('./library/sql.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$ss=$_REQUEST["ss"];

if($ss){
	$sql	 ="SELECT S.id, S.ssid, S.cast_id, S.customer_id, S.del, S.date, C.genji, U.block  FROM wp01_0ssid AS S";
	$sql	.=" LEFT JOIN wp01_0cast AS C ON C.id=S.cast_id";
	$sql	.=" LEFT JOIN wp01_0customer AS U ON U.id=S.customer_id";
	$sql	.=" WHERE ssid='{$ss}'";
	$sql	.=" ORDER BY S.id DESC";
	$sql	.=" LIMIT 1";

	$res2 = mysqli_query($mysqli,$sql);
	$ssid = mysqli_fetch_assoc($res2);

	if($ssid["id"]){
		if (file_exists("./img/profile/{$ssid["cast_id"]}/0_s.jpg")) {
			$face_link="./img/profile/{$ssid["cast_id"]}/0_s.jpg";			
			$face_link_l="./img/profile/{$ssid["cast_id"]}/0.jpg";			

		}else{
			$face_link="./img/cast_no_image.jpg";			
		}

		if($ssid["block"] == 3){
			$bk=1;

		}else{
			$bk=0;
		}

	}
}else{
	$err=2;
}
include_once('./easytalk_header.php');
?>
<?if($err==2){?>
	<div class="err_msg">
		タイムアウトしました<br>
		再度メールからログインしてください。<br>
	</div>
<?}elseif($err==1){?>
	<div class="err_msg">
		ログインコードが無効です。<br>
		最新のメールからログインしてください。<br>
	</div>
<?}else{?>
<script>
var SS='<?=$ss?>'
</script>

	<div class="easytalk_opt_flex">
		<div class="easytalk_sub_genji"><?=$ssid["genji"]?></div>
		<img src="<?=$face_link_l?>" class="easytalk_sub_img">

			<div class="easytalk_opt_msg">

				<label for="opt_0" class="label_opt">
					<span class="check2">
						<input id="opt_0" type="radio" name="opt" class="ck0" value="0" <?if($bk ==0){?>checked="checked"<?}?>>
						<span class="check1"></span>
					</span>EasyTalkを受け取る
				</label>

				<label for="opt_1" class="label_opt">
					<span class="check2">
						<input id="opt_1" type="radio" name="opt" class="ck0" value="1" <?if($bk ==1){?>checked="checked"<?}?>>
						<span class="check1"></span>
					</span>EasyTalkを受け取らない
				</label>
				<button id="opt_set" type="button" class="blog_cast_link">設定の変更</button>
				<div class="opt_done"></div>
			</div>


		<a href="<?=$admin_config["main_url"]?>" class="easytalk_sub_top" style="text-align:center;">店舗：<?=$admin_config["store_name"]?></a>
	</div>
<?}?>

<?include_once('./easytalk_footer.php'); ?>