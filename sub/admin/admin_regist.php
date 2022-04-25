<?
/*
$sql	 ="SELECT * FROM ".TABLE_KEY."_charm_table";
$sql	.=" WHERE del=0";
$sql	.=" AND view=0";
$sql	.=" ORDER BY sort ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($res_a = mysqli_fetch_assoc($res)){
		$charm_table[$res_a["id"]]=$res_a;
	}
}
*/


$sql	 ="SELECT * FROM ".TABLE_KEY."_check_main";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY sort ASC";
if($res1 = mysqli_query($mysqli,$sql)){
	while($res1_a = mysqli_fetch_assoc($res1)){
		$ck_main[$res1_a["id"]]=$res1_a;
	}

	$sql	 ="SELECT * FROM ".TABLE_KEY."_check_list";
	$sql	.=" WHERE del=0";
	$sql	.=" ORDER BY host_id ASC, list_sort ASC";

	if($res2 = mysqli_query($mysqli,$sql)){
		while($res2_a = mysqli_fetch_assoc($res2)){
			$ck_list[$res2_a["host_id"]][$res2_a["id"]]=$res2_a["list_title"];
		}
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE del=0";
$sql	.=" and tag_group='cast_group'";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cast_group[$row["id"]]=$row["tag_name"];
	}
}


$sql	 ="SELECT * FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE del=0";
$sql	.=" and tag_group='ribbon'";
$sql	.=" and sort>'3'";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cast_ribbon[$row["id"]]=$row["tag_name"];
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE del=0";
$sql	.=" and tag_group='prof'";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cast_prof[$row["id"]]=$row;
	}
}


?>
<style>
td{
	vertical-align:top;
	padding:5px;
}

#sel_staff,#sel_cast{
	display:none;
}

#staff_l{
	border-radius:10px 0 0 10px;
}

#cast_l{
	border-radius:0 10px 10px 0;
}

</style>
<link rel="stylesheet" href="./css/admin_image.css?t=<?=time()?>">
<script src="./js/image.js?_<?=time()?>"></script>
<script>
$(function(){ 
	$('#staff_l').on('click',function () {
		$(this).addClass('on_1');
		$('#cast_l').removeClass('on_2');
		$('.cast_table').fadeOut(100);
	});

	$('#cast_l').on('click',function () {
		$(this).addClass('on_2');
		$('#staff_l').removeClass('on_1');
		$('.cast_table').fadeIn(100);
	});

	$('#cast_l').on('click',function () {
		$(this).addClass('on_2');
		$('#staff_l').removeClass('on_1');
		$('.cast_table').fadeIn(100);
	});

	$('.staff_regist').on('click',function () {
		$('#wait').show();
		Tmp=$(this).attr('id');
		$('#send').val(Tmp);
		$('#form').submit();
	});
});
</script>
<form id="form" action="" method="post">
<input type="hidden" value="1" name="staff_set">
<input id="send" type="hidden" value="" name="send">
<header class="head">
<h2 class="head_ttl">スタッフ登録</h2>
<button id="set" type="button" class="submit_btn staff_regist">保存</button>
<button id="del" type="button" class="submit_btn staff_regist">削除</button>
<div class="c_s_box">
　<input id="sel_staff" value="1" type="radio" name="c_s"><label id="staff_l" for="sel_staff" class="c_s_btn">STAFF</label>
　<input id="sel_cast" value="0" type="radio" name="c_s" checked="checked"><label id="cast_l" for="sel_cast" class="c_s_btn on_2">CAST</label>
</div>
</header>
<div class="top_page"></div>
<div class="wrap">
<div class="main_box">
<table style="width:720px; table-layout: fixed;">
<tr>
<td class="table_title" colspan="3">
STAFF情報
</td>
</tr><tr>
<td>
	<div>名前			</div><input type="text" name="staff_name" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="staff_kana" class="w000" autocomplete="off">
</td><td>
	<div>生年月日		</div><input type="date" id="b_yy" name="b_date" class="w000" value="2000-01-01" autocomplete="off">
</td>
</tr><tr>
<td colspan="2">
	<div>住所			</div><span></span><input type="text" name="staff_address" class="w000" autocomplete="impp">
</td><td >
	<div>性別			</div>

<label for="sex1" class="ck_free">
	<span class="check2">
		<input id="sex1" type="radio" name="staff_sex" value="1" class="ck0" <?if($staff_sex+0<2){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	女性
</label>

<label for="sex2" class="ck_free">
	<span class="check2">
		<input id="sex2" type="radio" name="staff_sex" value="2" class="ck0" <?if($staff_sex == 2){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	男性
</label>

<label for="sex3" class="ck_free">
	<span class="check2">
		<input id="sex3" type="radio" name="staff_sex" value="3" class="ck0" <?if($staff_sex == 3){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	他
</label>
</td>
</tr><tr>
<td>
	<div>電話番号		</div><input id="ck_tel" type="text" name="staff_tel" class="w000 d_ck" autocomplete="off">
</td><td>
	<div>メールアドレス	</div><input id="ck_mail" type="text" name="staff_mail" class="w000 d_ck" autocomplete="off">
</td><td>
	<div>LINE			</div><input id="ck_line" type="text" name="staff_line" class="w000 d_ck" autocomplete="off">
</td>
</tr><tr>
<td>
	<div>役職			</div><input type="text" name="staff_position" class="w000" autocomplete="off">
</td><td>
	<div>ランク			</div><input type="text" name="staff_rank" class="w000" autocomplete="off">
</td><td>
	<?if(is_array($cast_group)){?>
	<div>グループ		</div>
	<select name="staff_group" class="w000" autocomplete="off">
	<?foreach($cast_group as $a1 => $a2){?>
	<option value="<?=$a1?>"><?=$a2?></option>
	<?}?>
	</select>
	<?}?>
</td>
</tr>
</table>
<table style="width:720px; table-layout: fixed;" class="cast_table">
<tr>
<td class="table_title" colspan="3">
CAST情報
</td>
</tr><tr>
<td>
	<div>CAST名			</div><input id="genji" type="text" name="genji" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="genji_kana" class="w000" autocomplete="off">
</td><td>
	<div>入店日		</div>
	<input type="date" name="c_date" class="w000" value="<?=date("Y-m-d")?>" autocomplete="off">
</td>
<tr>
	<td>
		<div>ログインID		</div><input id="ck_login_id" type="text" name="cast_id" value="" class="w000 d_ck" autocomplete="off">
	</td>
	<td>
		<div>ログインPASS	</div><input type="text" name="cast_pass" value="" class="w000" autocomplete="new_password">
	</td>
	<td>
		<div>リボン</div>
		<select name="cast_ribbon" class="w000">
			<option value="0">基本</option>
			$cast_ribbon[$row["id"]]=$row["tag_name"];
	<?foreach($cast_ribbon as $a1 => $a2){?>
			<option value="<?=$a1?>"<?if($staff_data["cast_ribbon"]==$a1){?> selected="selected"<?}?>><?=$a2?></option>
	<?}?>
		</select>
	</td>
</tr>
<tr>
	<td>
		<div>給与(時給)</div><input type="text" name="cast_salary" value="<?=$staff_data["cast_salary"]?>" class="w000" autocomplete="off">
	</td>
	<td></td>
	<td></td>
</tr>
</tr><tr>
</table>
<table style="width:720px;" class="cast_table" style="table-layout: fixed;">
<tr>
	<td class="table_title" colspan="2">NEWS登録</td>
</tr>	
<tr>
	<td style="width:240px;"><div>公開日</div>
	<input type="date" id="news_date_c" name="news_date_c" class="w000" value="<?=date("Y-m-d")?>" autocomplete="off"> 

	</td>
	<td><div>お知らせ内容</div>
	<textarea id="news_box" name="news_box" class="w000 tbox2" autocomplete="off">[name]ちゃんが入店します</textarea></td>
</tr>
</table>

<table style="width:720px; table-layout: fixed;" class="cast_table">
<tr>
	<td class="table_title" colspan="2">プロフィール</td>
</tr>	

<tr>
	<?foreach((array)$cast_prof as $a1 => $a2){?>
<td>
	<div><?=$a2["tag_name"]?></div>
	<?if($a2["tag_icon"] == 2){?>
		<textarea name="charm_table[<?=$a1?>]" class="w000 tbox" autocomplete="off"></textarea>
	<? }else{ ?>
		<input type="text" name="charm_table[<?=$a1?>]" class="w000" autocomplete="off">
	<? } ?>
</td>
<?if(($cnt+0) % 2 ==1){?>
</tr><tr>
<?}?>
<?$cnt++;?>
	<? } ?>
</tr>
</table>

<?foreach((array)$ck_main as $a1 => $a2){?>
<table style="width:720px; table-layout: fixed;" class="cast_table">
	<tr>
	<td class="table_title">
<span class="table_title cast_table"><?=$a2["title"]?></span>
</td></tr>
	<tr>
	<td>
		<?foreach((array)$ck_list[$a1] as $b1 => $b2){?>
		<input type="checkbox" id="sel_<?=$b1?>" name="options[<?=$b1?>]" class="ck_off" autocomplete="off" style="display:none; value="1">
		<label for="sel_<?=$b1?>" class="ck_box"><?=$b2?></label>
		<?}?>
	</td>
	</tr>
</table>
<? } ?>
</div>


<div class="main_box cast_table">
	<div class="img_box_flex">
	<?for($n=0;$n<4;$n++){?>
		<table class="r_img_box_table">
			<tr>
				<td class="img_box_td_1">
				<div class="img_box_td_1_in"><canvas id="cvs<?=$n?>" width="1200px" height="1600px;" class="cvs0"></canvas></div>
				<div class="img_box_out1"></div>
				<div class="img_box_out2"></div>
				<div class="img_box_out3"></div>
				<div class="img_box_out4"></div>
				<div class="img_box_out5"></div>
				<div class="img_box_out6"></div>
				<div class="img_box_out7"></div>
				<div class="img_box_out8"></div>

				<div id="p_stamp<?=$n?>" class="r_img_stamp">
				<img src="../img/stamp/stamp_0.png" class="r_img_stamp_in">
				<span id="d_stamp<?=$n?>" class="r_stamp_d"></span>
				</div>
				</td>
			</tr>
			<tr>
				<td class="img_box_td_2">
					<label for="upd<?=$n?>" class="img_up_file"></label>
					<span id="stamp<?=$n?>" type="button" class="img_up_stamp"></span>
					<span id="rote<?=$n?>" type="button" class="img_up_rote"></span>
					<span id="reset<?=$n?>" type="button" class="img_up_reset"></span>
					<span id="del<?=$n?>" type="button" class="img_up_del"></span>

					<div class="img_box_in3">
						<div id="mi<?=$n?>" class="zoom_mi">-</div>
						<div class="zoom_rg"><input id="zoom<?=$n?>" type="range" name="img_z[<?=$n?>]" min="100" max="200" step="1" value="100" class="range_bar"></div>
						<div id="pu<?=$n?>" class="zoom_pu">+</div><div id="zoom_box<?=$n?>" class="zoom_box">100</div>
					</div>

					<input type="hidden" value="<?if($face[$n]){?>0<?}else{?>1<?}?>" class="chg_check" name="chg_check[<?=$n?>]">

					<input id="c_<?=$n?>"type="hidden" value="" name="img_c[<?=$n?>]">
					<input id="w_<?=$n?>"type="hidden" value="" name="img_w[<?=$n?>]">
					<input id="h_<?=$n?>"type="hidden" value="" name="img_h[<?=$n?>]">

					<input id="x_<?=$n?>"type="hidden" value="" name="img_x[<?=$n?>]">
					<input id="y_<?=$n?>"type="hidden" value="" name="img_y[<?=$n?>]">

					<input id="r_<?=$n?>"type="hidden" value="" name="img_r[<?=$n?>]">
					<input id="v_<?=$n?>"type="hidden" value="" name="img_v[<?=$n?>]">

					<input id="sw_stamp<?=$n?>" type="hidden" value="" name="st_width[<?=$n?>]">
					<input id="sh_stamp<?=$n?>" type="hidden" value="" name="st_height[<?=$n?>]">

					<input id="sx_stamp<?=$n?>" type="hidden" value="" name="st_left[<?=$n?>]">
					<input id="sy_stamp<?=$n?>" type="hidden" value="" name="st_top[<?=$n?>]">


				</td>
			</tr>
		</table>
	<?}?>
	</div>
</div>
</form>
<input id="upd0" class="img_upd" type="file" accept="image/*" style="display:none;">
<input id="upd1" class="img_upd" type="file" accept="image/*" style="display:none;">
<input id="upd2" class="img_upd" type="file" accept="image/*" style="display:none;">
<input id="upd3" class="img_upd" type="file" accept="image/*" style="display:none;">
</div> 
<div class="alert_d">
	<div class="alert_d_1">
		他のスタッフで利用されているため使えません。
	</div>
	<div class="alert_d_2_out"></div>
	<div class="alert_d_3">
		重複元を修正するか、登録情報を変更してください。<br>
		このまま登録しますと、重複箇所は反映せずに登録されます。<br>
		※重複元を修正した際は「更新」をクリックしてください。<br>
	</div>
	<button type="button" class="alert_d_4">更新</button>
</div>
