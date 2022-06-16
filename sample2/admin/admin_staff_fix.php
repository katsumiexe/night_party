<?
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$staff_id=$_REQUEST["staff_id"];
$sql	 ="SELECT ";
$sql	.=" S.name, S.kana, S.tel, S.line, S.mail, S.address, S.birthday, S.sex, S.registday, S.rank, S.group, S.position, C.del, C.prm,";
$sql	.=" C.id, C.ctime, C.genji, C.genji_kana, C.cast_group, C.cast_sort, C.login_id, C.login_pass, C.cast_status, C.cast_salary, C.cast_ribbon";
$sql	.=" FROM ".TABLE_KEY."_staff AS S";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE staff_id={$staff_id}";
$sql	.=" AND S.del=0";
$sql	.=" LIMIT 1";

if($res = mysqli_query($mysqli,$sql) ){
	$staff_data = mysqli_fetch_assoc($res);
	$staff_data["birthday"]=substr($staff_data["birthday"],0,4)."-".substr($staff_data["birthday"],4,2)."-".substr($staff_data["birthday"],6,2);
	$staff_data["ctime"]=substr($staff_data["ctime"],0,4)."-".substr($staff_data["ctime"],4,2)."-".substr($staff_data["ctime"],6,2);
}

if($staff_data["del"]==='0'){

	$c_s=0;

}else{
	$c_s=1;
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_check_main";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$ck_main[$row["id"]]=$row;
	}
}

$sql	 ="SELECT L.id, host_id,list_sort,list_title,cast_id ,sel FROM ".TABLE_KEY."_check_list AS L";
$sql	.=" LEFT JOIN ".TABLE_KEY."_check_sel AS S ON L.id=S.list_id";
$sql	.=" AND(cast_id='{$staff_id}' OR cast_id IS NULL)";
$sql	.=" AND del=0";
$sql	.=" ORDER BY host_id ASC, list_sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$ck_sub[$row["host_id"]][$row["id"]]=$row;
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_charm_sel";
$sql	.=" WHERE cast_id='{$staff_id}'";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$charm_list[$row["list_id"]]=$row;
	}
}
for($n=0;$n<4;$n++){
	if(file_exists("../img/profile/{$staff_id}/{$n}.jpg")){
		$face[$n]="../img/profile/{$staff_id}/{$n}.jpg?t={$staff_data["prm"]}";		
	}
}


$sql	 ="SELECT * FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE del=0";
$sql	.=" AND tag_group='prof'";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$prof[$row["id"]]=$row;
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

<?if($c_s == 1){?>
.cast_table{
	display:none;
}
<? } ?>

</style>
<link rel="stylesheet" href="./css/admin_image.css?t=<?=time()?>">
<script src="./js/image.js?_<?=time()?>"></script>

<script>
$(function(){ 
<?foreach($face as $a1 => $a2){?>

	$("#cvs<?=$a1?>").attr({'width': 800,'height': 800}).css({'width': 200,'height': 200,'left': -5,'top': 20});
	cvs_box				= $("#cvs<?=$a1?>").get(0);
	cvs_dat[<?=$a1?>]	= cvs_box.getContext("2d");
	Img<?=$a1?>			= new Image();
	Img<?=$a1?>.src		="<?=$a2?>";

	Img<?=$a1?>.onload = function() {
		cvs_dat[<?=$a1?>].drawImage(Img<?=$a1?>, 0, 0, 600, 800, 100, 0, 600, 800); 
		ImgWidth[<?=$a1?>]	=200;
		ImgLeft[<?=$a1?>]	=-5;
		ImgTop[<?=$a1?>]	=20;
		Zoom[<?=$a1?>]		=100;
		Rote[<?=$a1?>]		=0;
		css_inX[<?=$a1?>]	=25;
		css_inY[<?=$a1?>]	= 0;

		css_outX[<?=$a1?>]= 150;
		css_outY[<?=$a1?>]= 200;
	};

	$('#r_<?=$a1?>').val(0);
	$('#zoom<?=$a1?>').val(100);
	$('#zoom_box<?=$a1?>').text(100);

	$('#w_<?=$a1?>').val('600');
	$('#h_<?=$a1?>').val('800');

	$('#x_<?=$a1?>').val('-5');
	$('#y_<?=$a1?>').val('20');
<?}?>

	$('#staff_l').on('click',function () {
		$(this).addClass('on_1');
		$('#cast_l').removeClass('on_2');
		$('.cast_table').fadeOut(100);
		$('#fix_flg').val('2');
	});


	$('#cast_l').on('click',function () {
		$(this).addClass('on_2');
		$('#staff_l').removeClass('on_1');
		$('.cast_table').fadeIn(100);
		$('#fix_flg').val('3');
	});

	$('.img_up_al').on('click',function(){
		$(this).parents('.img_box_table').animate({'left':'0'},200);
		$(this).parents('.img_box_table').next('.chg_check').val('0');
	});

	$('.img_up_al2,.img_box_in2').on('click',function(){
		$(this).parents('.img_box_table').animate({'left':'-192px'},200);
		$(this).parents('.img_box_table').next('.chg_check').val('1');
	});

	$('#fix_set').on('click',function(){
		if($('.ck_login_id_err').css("display") == "none"){
			if( $('#fix_select').val() == '5' ){
				if(!confirm('削除します。よろしいですか\nデータはすべて削除され、復旧はできません。')){
				    return false;
				}else{
					$('#wait').show();
					$('#fix_form').submit();
				}

			}else{
				$('#wait').show();
				$('#fix_form').submit();
			}
		}else{
			$('.ck_login_id_err').focus();
		}
	});

	$('#ck_login_id').on('change',function () {
		$(this).css("background-color","#fafafa");
		$('.ck_login_id_err').hide();

		$.ajax({
			url:'./post/id_check.php',
			type: 'post',
			data:{
				'set':"<?=$staff_id?>",
				'id':$(this).val()
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			if(data =="err"){
				$('#ck_login_id').css("background-color","#fff0f0");
				$('.ck_login_id_err').fadeIn(100);
			}

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

});
</script>
<form id="fix_form" action="" method="post" autocomplete="off">
<input type="hidden" value="<?=$staff_data["prm"]?>" name="prm">
<input id="staff_id" type="hidden" value="<?=$staff_id?>" name="staff_id">
<input id="fix_flg" type="hidden" value="2" name="staff_set">

<header class="head">
<h2 class="head_ttl">スタッフ登録</h2>
<select id="fix_select" class="w100" name="cast_status">
<option value="0">通常</option>
<option<?if($staff_data["cast_status"] == 1){?> selected="selected"<?}?> value="1">準備</option>
<option<?if($staff_data["cast_status"] == 2){?> selected="selected"<?}?> value="2">休職</option>
<option<?if($staff_data["cast_status"] == 3){?> selected="selected"<?}?> value="3">退職</option>
<option<?if($staff_data["cast_status"] == 4){?> selected="selected"<?}?> value="4">停止</option>
<option<?if($staff_data["cast_status"] == 5){?> selected="selected"<?}?> value="5">削除</option>
</select>
<button id="fix_set" type="submit" class="submit_btn">変更</button>
<div class="c_s_box">
　<input id="sel_staff" value="1" type="radio" name="c_s" class="sel_radio" <?if($c_s==1){?> checked="checked"<?}?>><label id="staff_l" for="sel_staff" class="c_s_btn<?if($c_s==1){?> on_1<?}?>">STAFF</label><input id="sel_cast" value="0" type="radio" name="c_s" class="sel_radio" <?if($c_s==0){?> checked="checked"<?}?>><label id="cast_l" for="sel_cast" class="c_s_btn<?if($c_s==0){?> on_2<?}?>">CAST</label>
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
	<div>名前			</div><input type="text" name="staff_name" value="<?=$staff_data["name"]?>" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="staff_kana" value="<?=$staff_data["kana"]?>" class="w000" autocomplete="off">
</td><td>
	<div>生年月日		</div><input type="date" id="b_yy" name="b_date" class="w000" value="<?=$staff_data["birthday"]?>" autocomplete="off">
</td>
</tr><tr>
<td colspan="2">
	<div>住所			</div><span></span><input type="text" name="staff_address" value="<?=$staff_data["address"]?>" class="w000">
</td><td >
	<div>性別			</div>
<label for="sex1" class="ck_free">
	<span class="check2">
		<input id="sex1" type="radio" name="staff_sex" value="1" class="ck0" <?if($staff_data["sex"]+0<2){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	女性
</label>

<label for="sex2" class="ck_free">
	<span class="check2">
		<input id="sex2" type="radio" name="staff_sex" value="2" class="ck0" <?if($staff_data["sex"]+0==2){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	男性
</label>

<label for="sex3" class="ck_free">
	<span class="check2">
		<input id="sex3" type="radio" name="staff_sex" value="3" class="ck0" <?if($staff_data["sex"]+0 == 3){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	他
</label>
</td>
</tr><tr>
<td>
	<div>電話番号		</div><input type="text" name="staff_tel" value="<?=$staff_data["tel"]?>" class="w000" autocomplete="off">
</td><td>
	<div>メールアドレス	</div><input type="text" name="staff_mail" value="<?=$staff_data["mail"]?>" class="w000" autocomplete="off">
</td><td>
	<div>LINE			</div><input type="text" name="staff_line" value="<?=$staff_data["line"]?>" class="w000" autocomplete="off">
</td>
</tr><tr>
<td>
	<div>役職			</div><input type="text" name="staff_position" value="<?=$staff_data["position"]?>" class="w000" autocomplete="off">
</td><td>
	<div>ランク			</div><input type="text" name="staff_rank" value="<?=$staff_data["rank"]?>" class="w000" autocomplete="off">
</td><td>
	<?if(is_array($cast_group)){?>
	<div>グループ		</div>
	<select name="staff_group" class="w000" autocomplete="off">
	<?foreach($cast_group as $a1 => $a2){?>
	<option value="<?=$a1?>"<?if($staff_data["group"]==$a1){?> selected="selected"<?}?>><?=$a2?></option>
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
	<div>CAST名			</div><input id="genji" type="text" name="genji" value="<?=$staff_data["genji"]?>" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="genji_kana" value="<?=$staff_data["genji_kana"]?>" class="w000" autocomplete="off">
</td><td>
	<div>入店日		</div>
	<input type="date" name="c_date" class="w000" value="<?=$staff_data["ctime"]?>" autocomplete="off">
</td>
</tr>
<tr>
	<td>
		<div>ログインID	</div><input type="text" name="cast_id" value="<?=$staff_data["login_id"]?>" class="w000" autocomplete="off">
		<div>ログインID <span class="ck_login_id_err" style="display:none;">既に使われています</span></div><input id="ck_login_id" type="text" name="cast_id" value="<?=$staff_data["login_id"]?>" class="w000 d_ck" autocomplete="off">
	</td>

	<td>
		<div>ログインPASS	</div><input type="text" name="cast_pass" value="<?=$staff_data["login_pass"]?>" class="w000" autocomplete="new_password">
	</td>
	<td>
		<div>リボン</div>
		<select name="cast_ribbon" class="w000">
			<option value="0">基本</option>
	<?foreach((array)$cast_ribbon as $a1 => $a2){?>
			<option value="<?=$a1?>"<?if($staff_data["cast_ribbon"]==$a1){?> selected="selected"<?}?>><?=$a2?></option>
	<?}?>
		</select>
	</td>
</tr>
<tr>
	<td>
		<div>時給		</div><input type="text" name="cast_salary" value="<?=$staff_data["cast_salary"]?>" class="w000" autocomplete="off">
	</td>
	<td></td>
	<td></td>
</tr>
</table>

<table style="width:720px; table-layout: fixed;" class="cast_table">
<tr>
	<td class="table_title" colspan="2">プロフィール</td>
</tr>	
<tr>
	<?foreach((array)$prof as $a1 => $a2){?>
		<td>
			<div><?=$a2["tag_name"]?></div>
			<?if($a2["tag_icon"] == 2){?>
				<textarea name="charm_table[<?=$a1?>]" class="w000 tbox" autocomplete="off"><?=$charm_list[$a1]["log"]?></textarea>
			<? }else{ ?>
				<input type="text" name="charm_table[<?=$a1?>]" class="w000" value="<?=$charm_list[$a1]["log"]?>" autocomplete="off">
			<? } ?>
		</td>

		<?if(($cnt+0) % 2 ==1){?>
			</tr><tr>
		<?}?>
		<?$cnt++;?>
	<? } ?>
</tr>
</table>

<?if($ck_main){?>
<?foreach($ck_main as $a1 => $a2){?>
	<table style="width:720px;" class="cast_table">
		<tr>
			<td class="table_title"><?=$a2["title"]?></td>
		</tr>
		<tr>
		<td><?if($ck_sub[$a1]){?><?foreach($ck_sub[$a1] as $b1 => $b2){?><input type="checkbox" id="sel_<?=$b1?>" name="options[<?=$b1?>]" class="ck_off" autocomplete="off" style="display:none; value="1"<?if($b2["sel"] == 1){?> checked="checked"<?}?>><label for="sel_<?=$b1?>" class="ck_box"><?=$b2["list_title"]?></label><?}?><?}?></td>
		</tr>
	</table>
<? } ?>
<? } ?>
<div style="height:20px;"></div>
</div>


<div class="main_box cast_table">
	<div class="img_box_flex">
	<?for($n=0;$n<4;$n++){?>
		<table class="r_img_box_table">
			<tr>
				<td class="img_box_td_1">
				<div class="img_box_td_1_in"><canvas id="cvs<?=$n?>" width="1200" height="1600;" class="cvs0"></canvas></div>
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
					<input id="c_<?=$n?>" type="hidden" value="" name="img_c[<?=$n?>]">

					<input id="w_<?=$n?>" type="hidden" value="" name="img_w[<?=$n?>]">
					<input id="h_<?=$n?>" type="hidden" value="" name="img_h[<?=$n?>]">

					<input id="x_<?=$n?>" type="hidden" value="" name="img_x[<?=$n?>]">
					<input id="y_<?=$n?>" type="hidden" value="" name="img_y[<?=$n?>]">

					<input id="r_<?=$n?>" type="hidden" value="" name="img_r[<?=$n?>]">
					<input id="v_<?=$n?>" type="hidden" value="" name="img_v[<?=$n?>]">

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
</form>
</div> 
