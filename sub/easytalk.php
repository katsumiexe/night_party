<?php
include_once('./library/sql.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$ss=$_REQUEST["ss"];
if($ss){
	$box_no="";
	$sql	 ="SELECT S.id, S.ssid, S.cast_id, S.customer_id, S.del, S.date, C.genji,U.block ,U.opt, C.prm FROM ".TABLE_KEY."_ssid AS S";
	$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON C.id=S.cast_id";
	$sql	.=" LEFT JOIN ".TABLE_KEY."_customer AS U ON U.id=S.customer_id";
	$sql	.=" WHERE ssid='{$ss}'";
	$sql	.=" AND S.del='0'";
	$sql	.=" ORDER BY S.id DESC";
	$sql	.=" LIMIT 1";

	$res2 = mysqli_query($mysqli,$sql);
	$ssid = mysqli_fetch_assoc($res2);

	if($ssid["id"]){
		$id_8=substr("00000000".$ssid["cast_id"],-8);
		$id_0	=$ssid["cast_id"] % 20;

		for($n=0;$n<8;$n++){
			$tmp_id=substr($id_8,$n,1);
			$box_no.=$dec[$id_0][$tmp_id];
		}
			$box_no.=$id_0;

		$sql	 ="UPDATE ".TABLE_KEY."_ssid SET";
		$sql	.=" del='1'";
		$sql	.=" WHERE id <'{$ssid["id"]}'";
		$sql	.=" AND cast_id='{$ssid["cast_id"]}'";
		$sql	.=" AND customer_id='{$ssid["customer_id"]}'";
		mysqli_query($mysqli,$sql);



		if (file_exists("./img/profile/{$ssid["cast_id"]}/0_s.webp") && $admin_config["webp_select"] == 1) {
			$face_link="./img/profile/{$ssid["cast_id"]}/0_s.webp";			
			$face_link_l="./img/profile/{$ssid["cast_id"]}/0.webp";			

		}elseif (file_exists("./img/profile/{$ssid["cast_id"]}/0_s.jpg")){
			$face_link="./img/profile/{$ssid["cast_id"]}/0_s.jpg";			
			$face_link_l="./img/profile/{$ssid["cast_id"]}/0.jpg";			

		}else{
			$face_link="./img/cast_no_image.jpg";			
			$face_link_l="./img/cast_no_image.jpg";			
		}

		$cnt=0;
		$sql	 ="SELECT * FROM ".TABLE_KEY."_easytalk";
		$sql	.=" WHERE customer_id='{$ssid["customer_id"]}' AND cast_id='{$ssid["cast_id"]}'";
		$sql	.=" AND mail_del=0";
		$sql	.=" ORDER BY mail_id DESC";
		$sql	.=" LIMIT 11";

		if($res = mysqli_query($mysqli,$sql)){
			while($a1 = mysqli_fetch_assoc($res)){
				$dat[$cnt]=$a1;
				$dat[$cnt]["log"]=str_replace("\n","<br>",$dat[$cnt]["log"]);
				$dat[$cnt]["send_date"]=str_replace("-",".",$dat[$cnt]["send_date"]);
				$dat[$cnt]["send_date"]=substr($dat[$cnt]["send_date"],0,16);

				if($dat[$cnt]["watch_date"] ==''){
					$dat[$cnt]["kidoku"]="<span class=\"midoku\">未読</span>";
				}else{
					$dat[$cnt]["kidoku"]="<span class=\"kidoku\">既読</span>";
					$dat[$cnt]["bg"]=1;
				}

				if($dat[$n]["watch_date"] =='' && $dat[$cnt+1]["watch_date"] !=''){
					$dat[$cnt]["border"]="<div class=\"mail_border\">----------ここから新着--------------</div>";
					$html=$dat[$cnt]["watch_date"];
				}
				if (file_exists("./img/cast/{$box_no}/m/{$dat[$cnt]["img"]}.webp") && $admin_config["webp_select"] == 1) {
					$dat[$cnt]["stamp"]="<img src=\"./img/cast/{$box_no}/m/{$dat[$cnt]["img"]}.webp\" class=\"blog_img\">";

				}elseif (file_exists("./img/cast/{$box_no}/m/{$dat[$cnt]["img"]}.png")) {
					$dat[$cnt]["stamp"]="<img src=\"./img/cast/{$box_no}/m/{$dat[$cnt]["img"]}.png\" class=\"blog_img\">";
				}
				$cnt++;
			}
		}

		if($cnt>10){
			$cnt=10;
			$app="<div class=\"mail_detail_in_btm\">　</div>";
		}

		$sql	 ="UPDATE ".TABLE_KEY."_easytalk SET";
		$sql	.=" watch_date='{$now}'";
		$sql	.=" WHERE customer_id='{$ssid["customer_id"]}' AND cast_id='{$ssid["cast_id"]}' AND send_flg='1' AND watch_date IS NULL";
		mysqli_query($mysqli,$sql);

	}else{
		$err=1;
	}

}else{
	$err=2;
}
include_once('./easytalk_header.php');
?>


<div class="main_top_flex">
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

		<div class="easytalk_sub">
			<div class="easytalk_sub_genji"><?=$ssid["genji"]?></div>
			<span  class="easytalk_sub_img_out"><img src="<?=$face_link_l?>" class="easytalk_sub_img"></span>
			<a id="e_prof" href="./person.php?post_id=<?=$ssid["cast_id"]?>" class="easytalk_sub_link" target="_BLANK">Profile</a>
			<a id="e_blog" href="./castblog.php?cast_list=<?=$ssid["cast_id"]?>" class="easytalk_sub_link" target="_BLANK">Blog</a>

			<div class="easytalk_sub_opt_title"><span class="easytalk_icon"></span>設定</div>
			<div class="easytalk_sub_opt">
				<label for="opt_0" class="label_opt">
					<span class="check2">
						<input id="opt_0" type="radio" name="opt" class="ck0" value="0" <?if($ssid["opt"] == 0){?>checked="checked"<?}?>>
						<span class="check1"></span>
					</span>受信する
				</label>
				<label for="opt_1" class="label_opt">
					<span class="check2">
						<input id="opt_1" type="radio" name="opt" class="ck0" value="1" <?if($ssid["opt"] == 1){?>checked="checked"<?}?>>
						<span class="check1"></span>
					</span>受信しない
				</label>
			</div>
			<div class="easytalk_sub_opt_chg">設定を変更しました</div>
		</div>

		<div class="main_article">
			<?if($ssid["block"] >1 || $ssid["opt"] == 1){?>
				<div class="mail_box_b new_set"><div class="mail_box_new_ng">
				<div class="mail_box_new_msg2"><span class="mail_box_icon"></span>メッセージは送信できません</div></div></div>
			<?}else{?>
				<div class="mail_box_b new_set"><div class="mail_box_new">
					<div class="mail_box_new_msg"><span class="mail_box_icon"></span>メッセージの作成<span class="mail_box_new_del">×</span></div>
						<div class="mail_box_new_in">
							<div class="mail_box_new_log_out"><textarea id="easytalk_text" class="mail_box_new_log"></textarea></div>
							<?if($ssid["block"]+0 ==0){?>
								<img id="easytalk_img" src="./img/blog_no_image.png?t_<?=time()?>" class="mail_img_view" alt="画像登録">
							<?}else{?>
								<br><div style="color:#d00000;font-size:14px;">画像の送信はできません</div>
							<?}?>
							<button id="easytalk_send" class="mail_box_new_btn esend"><span class="mail_box_icon"></span>メッセージを送信する</button>
							<input type="hidden" id="img_code" value="">
							<input type="hidden" id="ssid" name="ss" value="<?=$ss?>">
						</div>
					</div>
				</div>
			<?}?>

			<?for($n1=0;$n1<$cnt;$n1++){?>
				<?if($dat[$n1]["send_flg"] == 1){?>
					<div class="mail_box_a">		
						<div class="mail_box_face">
							<img src="<?=$face_link?>" class="mail_box_img">
						</div>
						<div class="mail_box_a_right">
							<span class="mail_box_date_a"><?=$dat[$n1]["send_date"]?></span>
							<div class="mail_box_log_1">
								<div class="mail_box_log_in">
									<?=$dat[$n1]["log"]?>
								</div>
								<?=$dat[$n1]["stamp"]?>
							</div>
						</div>
					</div>
					<?=$dat[$n1]["border"]?>
				<?}else{?>

					<div class="mail_box_b">		
						<span class="mail_box_date_b"><?=$dat[$n1]["send_date"]?>　<?=$dat[$n1]["kidoku"]?></span>
						<div class="mail_box_log_2 bg<?=$dat[$n1]["bg"]?>">
							<div class="mail_box_log_in">
								<?=$dat[$n1]["log"]?>
							</div>
							<?=$dat[$n1]["stamp"]?>
						</div>
					</div>
				<? } ?>

			<? } ?>
			<?=$app?>
		</div>
	<? } ?>
</div>
</div>
<div class="img_box">
	<div id="img_close" class="btn_c2">×</div>　
	<div class="img_box_in">
		<canvas id="cvs1" width="800px" height="800px;"></canvas>
		<div class="img_box_out1"></div>
		<div class="img_box_out2"></div>
		<div class="img_box_out3"></div>
		<div class="img_box_out4"></div>
		<div class="img_box_out5"></div>
		<div class="img_box_out6"></div>
		<div class="img_box_out7"></div>
		<div class="img_box_out8"></div>
	</div>

	<div class="img_box_in2">
		<label for="upd" class="upload_btn"><span class="upload_icon_p"></span><span class="upload_txt">画像選択</span></label>
		<span class="upload_icon_p upload_rote"></span>
		<span class="upload_icon_p upload_trush"></span>

		<div class="img_box_in3">
			<div class="zoom_mi">-</div>
			<div class="zoom_rg"><input id="input_zoom" type="range" name="num" min="100" max="300" step="1" value="100" class="range_bar"></div>
			<div class="zoom_pu">+</div>
			<div class="zoom_box">100</div>
		</div>

		<div id="img_set" class="btn_c1">登録</div>　
		<div id="img_reset" class="btn_c3">リセット</div>
	</div>
	<input id="upd" type="file" accept="image/*" style="display:none;">
	<canvas id="cvs2" width="800px" height="800px;"></canvas>
</div>
<div id="wait" class="wait">
<div class="wait_in"></div>
</div>

<script>
$(function(){
	setInterval(function(){
		$.ajax({
			type:"post",
			url:"./post/easytalk_auto.php",
			data:{

				'c_id'		:'<?=$ssid["customer_id"]?>',
				'cast_id'	:'<?=$ssid["cast_id"]?>',
				'face'		:'<?=$face_link?>',
				'midoku'	:$('.midoku').text(),
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			console.log(data.length);
			console.log(data.midoku);

			if(data["midoku"]){
				var Mido=0;
				$.each(data.midoku, function(index, val) {
					$('#mail_hist'+index).addClass("mail_yet");
					$('#mail_hist'+index).children('.mail_count').show();
					Mido++;
				});

				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span><span class=\"easy_midoku\">"+Mido+"</span>");
				$('.midoku_count').fadeIn(500).text(Mido);

			}else{
				$('.midoku_count').hide();
				$('.midoku_btn').removeClass('midoku_on');
				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span>");
			}

			if(data.kidoku>0){
				$.when(
					$('.midoku').after("<span class=\"kidoku\">既読</span>")
				).done(function(){
					$('.midoku').remove();
					$('.bg').animate({'background-color':'#d0ffe0'},400);
				})
			}

			if(data.html){
				$.when(
					$('.new_set').after(data.html),

				).done(function(){
					$('.tl_append').slideDown(1000);
				});
			}
		});

	},10000);
});
</script>
<?include_once('./easytalk_footer.php'); ?>
