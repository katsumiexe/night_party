<?php
include_once("./sample1/library/sql.php");

$code	=$_REQUEST["code"];

$sql ="SELECT * FROM sheet";
$sql.=" LEFT JOIN sheet_pay ON sheet.code=sheet_pay.pay_code";
$sql.=" WHERE code='{$code}'";
$sql.=" ORDER BY id DESC";
$sql.=" LIMIT 1";
$result = mysqli_query($mysqli,$sql);
$dat = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title>Night-Party ヒアリングシート</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){ 
	var Fin=0;

	var Ck1=0;
	var Ck2=0;
	var Ck3=0;
	var Ck4=0;
	var Ck5=0;
	var Ck6=0;
	var Ck7=0;
	var Ck8=0;
	var Ck9=0;
	var Ck10=0;
	var Ck11=0;
	var Ck12=0;
	var Ck13=0;
	var Ck14=0;
	var Ck15=0;

	var PayC0=0;
	var PayC1=0;
	var PayC2=0;
	var PayC3=0;
	var PayC4=0;
	var PayC5=0;
	var PayC6=0;
	var PayC7=0;
	var PayC8=0;
	var PayC9=0;

	var RecC1=0;
	var RecC2=0;
	var RecC3=0;
	var RecC4=0;
	var RecC5=0;
	var RecC6=0;
	var RecC7=0;
	var RecC8=0;


	$('.ques').hover(function() {
		$(this).children('.ans').fadeIn(300);
	},function() {
		$('.ans').fadeOut(200);
	});

	$('.tmp_btn').on('click',function() {
		if($(this).attr('id') == "fin"){
			Fin=1;
		}

		if($('#ck_1').prop('checked')==true){
			Ck1=1;
		}

		if($('#ck_2').prop('checked')==true){
			Ck2=1;
		}

		if($('#ck_3').prop('checked')==true){
			Ck3=1;
		}

		if($('#ck_4').prop('checked')==true){
			Ck4=1;
		}

		if($('#ck_5').prop('checked')==true){
			Ck5=1;
		}

		if($('#ck_6').prop('checked')==true){
			Ck6=1;
		}

		if($('#ck_7').prop('checked')==true){
			Ck7=1;
		}

		if($('#ck_8').prop('checked')==true){
			Ck8=1;
		}

		if($('#ck_9').prop('checked')==true){
			Ck9=1;
		}

		if($('#ck_10').prop('checked')==true){
			Ck10=1;
		}

		if($('#ck_11').prop('checked')==true){
			Ck11=1;
		}

		if($('#ck_12').prop('checked')==true){
			Ck12=1;
		}

		if($('#ck_13').prop('checked')==true){
			Ck13=1;
		}

		if($('#ck_14').prop('checked')==true){
			Ck14=1;
		}

		if($('#ck_15').prop('checked')==true){
			Ck15=1;
		}

		if($('#rec_c_1').prop('checked')==true){
			RecC1=1;
		}

		if($('#Rec_c_2').prop('checked')==true){
			RecC2=1;
		}

		if($('#rec_c_3').prop('checked')==true){
			RecC3=1;
		}

		if($('#rec_c_4').prop('checked')==true){
			RecC4=1;
		}

		if($('#rec_c_5').prop('checked')==true){
			RecC5=1;
		}

		if($('#rec_c_6').prop('checked')==true){
			RecC6=1;
		}

		if($('#rec_c_7').prop('checked')==true){
			RecC7=1;
		}

		if($('#rec_c_8').prop('checked')==true){
			RecC8=1;
		}

		if($('#pay_c_0').prop('checked')==true){
			PayC0=1;
		}
		if($('#pay_c_1').prop('checked')==true){
			PayC1=1;
		}
		if($('#pay_c_2').prop('checked')==true){
			PayC2=1;
		}
		if($('#pay_c_3').prop('checked')==true){
			PayC3=1;
		}
		if($('#pay_c_4').prop('checked')==true){
			PayC4=1;
		}
		if($('#pay_c_5').prop('checked')==true){
			PayC5=1;
		}
		if($('#pay_c_6').prop('checked')==true){
			PayC6=1;
		}
		if($('#pay_c_7').prop('checked')==true){
			PayC7=1;
		}
		if($('#pay_c_8').prop('checked')==true){
			PayC8=1;
		}

		if($('#pay_c_9').prop('checked')==true){
			PayC9=1;
		}




		$.ajax({
			url:'./z_post/sheet_set.php',
			type: 'post',
			data:{
				'fin':Fin,
				'code':'<?=$dat["code"]?>',
	
				'info_1':$('#info_1').val(),
				'info_2':$('#info_2').val(),
				'info_3':$('#info_3').val(),
				'info_4':$('#info_4').val(),
				'info_5':$('#info_5').val(),
				'info_6':$('#info_6').val(),
				'info_7':$('#info_7').val(),
				'info_8':$('#info_8').val(),
				'info_9':$('#info_9').val(),
				'info_10':$('#info_10').val(),
				'info_11':$('#info_11').val(),
				'info_12':$('#info_12').val(),
				'info_13':$('#info_13').val(),

				'pf_0':$('#pf_0').val(),
				'pf_1':$('#pf_1').val(),
				'pf_2':$('#pf_2').val(),
				'pf_3':$('#pf_3').val(),
				'pf_4':$('#pf_4').val(),
				'pf_5':$('#pf_5').val(),
				'pf_6':$('#pf_6').val(),
				'pf_7':$('#pf_7').val(),

				'op_0':$('#op_0').val(),
				'op_1':$('#op_1').val(),
				'op_2':$('#op_2').val(),
				'op_3':$('#op_3').val(),
				'op_4':$('#op_4').val(),
				'op_5':$('#op_5').val(),
				'op_6':$('#op_6').val(),
				'op_7':$('#op_7').val(),
				'op_8':$('#op_8').val(),
				'op_9':$('#op_9').val(),
				'op_10':$('#op_10').val(),
				'op_11':$('#op_11').val(),

				'pg_0':$('#pg_0').val(),
				'pg_1':$('#pg_1').val(),

				'rec_0':$('#rec_0').val(),
				'rec_1':$('#rec_1').val(),
				'rec_2':$('#rec_2').val(),
				'rec_3':$('#rec_3').val(),
				'rec_4':$('#rec_4').val(),
				'rec_5':$('#rec_5').val(),
				'rec_6':$('#rec_6').val(),
				'rec_7':$('#rec_7').val(),
				'rec_8':$('#rec_8').val(),

				'rec_c_1':RecC1,
				'rec_c_2':RecC2,
				'rec_c_3':RecC3,
				'rec_c_4':RecC4,
				'rec_c_5':RecC5,
				'rec_c_6':RecC6,
				'rec_c_7':RecC7,
				'rec_c_8':RecC8,

				'bn_0':$('#bn_0').val(),
				'bn_1':$('#bn_1').val(),

				'ck_1':Ck1,
				'ck_2':Ck2,
				'ck_3':Ck3,
				'ck_4':Ck4,
				'ck_5':Ck5,
				'ck_6':Ck6,
				'ck_7':Ck7,
				'ck_8':Ck8,
				'ck_9':Ck9,
				'ck_10':Ck10,
				'ck_11':Ck11,
				'ck_12':Ck12,
				'ck_13':Ck13,
				'ck_14':Ck14,
				'ck_15':Ck15,

				'pay_0':$('#pay_0').val(),
				'pay_1':$('#pay_1').val(),
				'pay_2':$('#pay_2').val(),
				'pay_3':$('#pay_3').val(),
				'pay_4':$('#pay_4').val(),
				'pay_5':$('#pay_5').val(),
				'pay_6':$('#pay_6').val(),
				'pay_7':$('#pay_7').val(),
				'pay_8':$('#pay_8').val(),
				'pay_9':$('#pay_9').val(),

				'pay_c_0':PayC0,
				'pay_c_1':PayC1,
				'pay_c_2':PayC2,
				'pay_c_3':PayC3,
				'pay_c_4':PayC4,
				'pay_c_5':PayC5,
				'pay_c_6':PayC6,
				'pay_c_7':PayC7,
				'pay_c_8':PayC8,
				'pay_c_9':PayC9,
			},

		}).done(function(data, textStatus, jqXHR){
console.log(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
});
</script>

<style>
@font-face {
	font-family: at_icon;
	src: url("./sample1/font/nightparty_icon.ttf") format('truetype');
}

td{
	vertical-align:top;
}

input,select{
	height			:30px;
	line-height		:30px;
	padding-left	:10px;
	border			:1px solid #303030;
	margin			:0 5px 5px 5px;
}

.textarea,.textarea2{
	height			:100px;
	font-size		:15px;
	line-height		:22px;
	padding			:5px;
	border			:1px solid #303030;
	margin			:0 5px 5px 5px;
	resize			:none;
}

.textarea2{
	height			:200px;
}

.td_title{
	background		:#000090;
	color			:#fafafa;
	font-size		:16px;
	height			:30px;
	line-height		:30px;
	text-align		:center;
}

.title_1{
	position		:relative;
	background		:#6060a0;
	color			:#fafafa;
	font-size		:18px;
	height			:40px;
	line-height		:40px;
	text-align		:left;
	width			:100%;
	margin			:30px auto 5px auto;
}

.tmp_btn,.tmp_btn2{
	position		:absolute;
	top				:0;
	bottom			:0;
	right			:5px;
	margin			:auto;
	font-size		:12px;
	height			:30px;
	line-height		:30px;
	width			:100px;
}

.tmp_btn2{
	background		:#c00000;
	color			:#fafafa;
}



.td_tag{
	position		:relative;
	display			:block;
	font-size		:16px;
	font-weight		:700;
	height			:30px;
	line-height		:40px;
	width			:100%;
}

.td_tag2{
	position		:relative;
	display			:block;
	font-size		:16px;
	font-weight		:700;
	height			:40px;
	line-height		:50px;
	width			:100%;
}

.pay_price{
	position		:absolute;
	top				:0;
	bottom			:0;
	right			:20px;
	margin			:auto;
	color			:#c00000;
	font-weight		:700;
}

.ck_title{
	margin			:5px;
	background		:#906000;
	color			:#fafafa;
	height			:24px;
	line-height		:24px;
	font-size		:15px;
	font-weight		:700;
	text-align		:center;
}

.ck_box0{
	display			:inline-block;
	vertical-align	:top;
	font-size		:14px;
	position		:relative;
	padding-left	:20px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	width			:160px;
}

.ck_box0:checked + .check1{
	display				:inline-block;
}


.ck_box3{
	display				:none;
	position			:absolute;
	left				:6px;
	bottom				:0;
	width				:16px;
	height				:11px;
	border-bottom		:4px solid #a00000;
	border-left			:4px solid #a00000;
	transform			:rotate(-55deg);
	transform-origin	:left bottom
}

.ck_box2{
	display				:none;
}
.ck_box2:checked + .ck_box3{
	display				:inline-block;
}

.ck_box1{
	display				:inline-block;
	position			:absolute;
	left				:2px;
	top					:0;
	bottom				:0;
	margin				:auto;
	width				:12px;
	height				:12px;
	border				:2px solid #303030;
	background			:#fafafa;
}

.ques{
	display			:inline-block;
	width			:18px;
	height			:18px;
	line-height		:18px;
	text-align		:center;
	position		:absolute;
	top				:0;
	right			:5px;
	font-family		:at_icon;
	color			:#ff30c0;
}

.ans{
	display			:none;
	position		:absolute;
	top				:25px;
	right			:-5px;
	padding			:5px;
	font-size		:13px;
	background		:#fff0e0;
	border			:1px solid #202020;
	color			:#202020;	
	line-height		:18px;
	width			:150px;
	z-index			:3;
	text-align		:left;
}

.nese{
	display			:inline-block;
	line-height		:30px;
	height			:30px;
	width			:50px;
	text-align		:center;
	font-size		:14px;
	background		:#f0f0f0;
	border			:1px solid #202020;
}

.rec_c{
	display:none;
}

.rec_c:checked + label{
	background:#ffe0e0;
}

.w40{
	width:40px;
}

.w60{
	width:60px;
}

.w80{
	width:80px;
}

.w100{
	width:100px;
}

.w160{
	width:160px;
}

.w240{
	width:240px;
}

.w300{
	width:300px;
}

.w360{
	width:360px;
}

.w540{
	width:540px;
}

.w560{
	width:560px;
}

.box_1,.box_2{
	position		:relative;
	width			:100%;
	max-width		:600px;
	margin			:0 auto;
	background		:#fafafa;

}

.wr{
	text-align		:right;
	padding-right	:10px;
}

.info_0_out{
	width		:100%;
	position	:relative;
	height		:60px;
}

.info_0_a,.info_0_b{
	display:block;
	width		:280px;
	height		:40px;
	position	:absolute;
	top			:0;
	line-height	:40px;
	color		:#ffffff;
	font-size	:18px;
	text-align	:center;
}

.info_0_a{
	background	:#c4c4c4;
	left		:5px;
	border-radius:10px 0 0 0;
}

.info_0_b{
	background	:#0000f0;
	right		:5px;
	border-radius:0 10px 0 0;
}

.info_0_a:after{
	position	:absolute;
	top			:0;
	right		:0px;
	content		:"";
	transform	: skew(25deg);
	width		:30px;
	height		:40px;
	background	:#c4c4c4;
	display		:block;
	transform-origin:top left;
}

.info_0_b:before{
	position	:absolute;
	top			:0;
	left		:-30px;
	content		:"";
	transform	: skew(-25deg);
	width		:30px;
	height		:40px;
	background	:#0000f0;
	display		:block;
	transform-origin:bottom right;
}
</style>
</head>

<body style="background:#eaeaea">
<div class="box_1"><?=$dat["user"]?>様 ヒアリングシート<button type="button" class="tmp_btn2">送信</button></div>
<div class="box_2">




<div class="title_1">　店舗基本情報<button type="button" class="tmp_btn">下書き保存</button></div>
<span class="td_tag">　店舗名</span>
<input id="info_1" name="info_1" type="text" class="textbox w360" value="<?=$dat["info_1"]?>">

<span class="td_tag">　ご住所</span>
<input id="info_2" name="info_2" type="text" class="textbox w360" value="<?=$dat["info_2"]?>">

<span class="td_tag">　お電話番号</span>
<input id="info_3" name="info_3" class="textbox w360" value="<?=$dat["info_3"]?>">

<span class="td_tag">　メールアドレス</span>
<input id="info_4" name="info_4" type="text" class="textbox w360" value="<?=$dat["info_4"]?>">

<span class="td_tag">　LINE</span>
<input id="info_5" name="info_5" type="text" class="textbox w360" value="<?=$dat["info_5"]?>">

<span class="td_tag">　twitter</span>
<input id="info_6" name="info_6" type="text" class="textbox w360" value="<?=$dat["info_6"]?>">

<span class="td_tag">　店舗形態</span>
<select id="info_7" name="info_7" class="textbox" style="width:375px;">
	<option></option>
	<option value="キャバクラ"<? if($dat["info_1"]=="キャバクラ"){?> selected="selected"<?}?>>キャバクラ</option>
	<option value="セクキャバ"<? if($dat["info_1"]=="セクキャバ"){?> selected="selected"<?}?>>セクキャバ</option>
	<option value="ガールズバー"<? if($dat["info_1"]=="ガールズバー"){?> selected="selected"<?}?>>ガールズバー</option>
	<option value="デリヘル"<? if($dat["info_1"]=="デリヘル"){?> selected="selected"<?}?>>デリヘル</option>
	<option value="コンカフェ"<? if($dat["info_1"]=="コンカフェ"){?> selected="selected"<?}?>>コンカフェ</option>
	<option value="メイドカフェ"<? if($dat["info_1"]=="メイドカフェ"){?> selected="selected"<?}?>>メイドカフェ</option>
	<option value="アイドルカフェ"<? if($dat["info_1"]=="アイドルカフェ"){?> selected="selected"<?}?>>アイドルカフェ</option>
	<option value="スポーツバー"<? if($dat["info_1"]=="スポーツバー"){?> selected="selected"<?}?>>スポーツバー</option>
	<option value="ダーツバー"<? if($dat["info_1"]=="ダーツバー"){?> selected="selected"<?}?>>ダーツバー</option>
	<option value="SMバー"<? if($dat["info_1"]=="SMバー"){?> selected="selected"<?}?>>SMバー</option>
	<option value="ハプニングバー"<? if($dat["info_1"]=="ハプニングバー"){?> selected="selected"<?}?>>ハプニングバー</option>
	<option value="その他"<? if($dat["info_1"]=="その他"){?> selected="selected"<?}?>>その他</option>
</select><br>

<span class="td_tag" style="display:inline-block; width:145px;">　キャスト数</span>
<span class="td_tag" style="display:inline-block; width:145px;">　顧客年齢層</span>
<span class="td_tag" style="display:inline-block; width:145px;">　営業時間</span><br>

<input id="info_8" name="info_8" type="text" value="<?=$dat["info_8"]?>" class="textbox w80 wr">人　
<input id="info_9" name="info_9" type="text" value="<?=$dat["info_9"]?>" class="textbox w80 wr">歳　
<input id="info_10" name="info_10" type="text" value="<?=$dat["info_10"]?>" class="textbox w40 wr">時 ～<input id="info_11" type="text" value="<?=$dat["info_11"]?>" class="textbox w40 wr">時

<div class="title_1">　サイトデザイン<button type="button" class="tmp_btn">下書き保存</button></div>

<div class="info_0_out">
<input id="info_0a" name="info_0" type="radio" class="info_0"><label for="info_0a" class="info_0_a">テーマ01：ソワレ</label>
<input id="info_0b" name="info_0" type="radio" class="info_0"><label for="info_0b" class="info_0_b">テーマ02：コーマ</label>
</div>


<span class="td_tag" style="display:inline-block; width:380px;">　イメージサイトURL</span><span class="td_tag w160" style="display:inline-block;">　イメージカラー</span>
<input id="info_12" type="text" value="<?=$dat["info_12"]?>" class="textbox w360"><input id="info_13" name="dg_3" type="text" class="textbox w160">
<span class="td_tag">　ご要望</span>
<textarea id="info_13" value="<?=$dat[""]?>" class="textarea2 w540"><?=$dat["info_13"]?></textarea>


<div class="title_1">　キャスト設定<button type="button" class="tmp_btn">下書き保存</button></div>
<span class="td_tag">　キャストプロフィール</span>
<input id="pf_0" type="text" value="<?=$dat["pf_0"]?>" class="textbox w360" placeholder="誕生日／年齢">
<input id="pf_1" type="text" value="<?=$dat["pf_1"]?>" class="textbox w360" placeholder="趣味">
<input id="pf_2" type="text" value="<?=$dat["pf_2"]?>" class="textbox w360" placeholder="好きな食べ物">
<input id="pf_3" type="text" value="<?=$dat["pf_3"]?>" class="textbox w360" placeholder="お酒">
<input id="pf_4" type="text" value="<?=$dat["pf_4"]?>" class="textbox w360">
<input id="pf_5" type="text" value="<?=$dat["pf_5"]?>" class="textbox w360">
<input id="pf_6" type="text" value="<?=$dat["pf_6"]?>" class="textbox w360">
<input id="pf_7" type="text" value="<?=$dat["pf_7"]?>" class="textbox w360">


<span class="td_tag">　オプション名</span>
<input id="op_0" type="text" class="textbox w360" value="<?=$dat["op_0"]?>"  placeholder="特徴"><br>
<input id="op_1" type="text" class="textbox w180" value="<?=$dat["op_1"]?>" placeholder="理系">
<input id="op_2" type="text" class="textbox w180" value="<?=$dat["op_2"]?>" placeholder="体育会系">
<input id="op_3" type="text" class="textbox w180" value="<?=$dat["op_3"]?>" placeholder="お話好き">
<input id="op_4" type="text" class="textbox w180" value="<?=$dat["op_4"]?>" placeholder="オタク">
<input id="op_5" type="text" class="textbox w180" value="<?=$dat["op_5"]?>" placeholder="巨乳">
<input id="op_6" type="text" class="textbox w180" value="<?=$dat["op_6"]?>" placeholder="モデル体型">
<input id="op_7" type="text" class="textbox w180" value="<?=$dat["op_7"]?>">
<input id="op_8" type="text" class="textbox w180" value="<?=$dat["op_8"]?>">
<input id="op_9" type="text" class="textbox w180" value="<?=$dat["op_9"]?>">
<input id="op_10" type="text" class="textbox w180" value="<?=$dat["op10_"]?>">
<input id="op_11" type="text" class="textbox w180" value="<?=$dat["op_11"]?>">

<div class="title_1">　システム<button type="button" class="tmp_btn">下書き保存</button></div>
<span class="td_tag">　本文</span>
<textarea id="pg_0" class="textarea2 w560"></textarea>


<div class="title_1">　リクルート<button type="button" class="tmp_btn">下書き保存</button></div>
<span class="td_tag">　本文</span>
<textarea id="rec_0" class="textarea2 w560"><?=$dat["rec_0"]?></textarea>
<span class="td_tag">　確認項目</span>

<input id="rec_1" type="text" value="<?=$dat["rec_1"]?>" class="textbox w300" placeholder="お名前"><input type="checkbox" value="1" <? if($dat["rec_c_1"]=="1"){?> checked="checked"<?}?> id="rec_c_1" name="rec_c_1" class="rec_c" ><label for="rec_c_1" class="nese">必須</label>
<input id="rec_2" type="text" value="<?=$dat["rec_2"]?>" class="textbox w300" placeholder="ご住所"><input type="checkbox" value="1" <? if($dat["rec_c_2"]=="1"){?> checked="checked"<?}?> id="rec_c_2" name="rec_c_2" class="rec_c"><label for="rec_c_2" class="nese">必須</label>
<input id="rec_3" type="text" value="<?=$dat["rec_3"]?>" class="textbox w300"><input type="checkbox" id="rec_c_3" value="1" <? if($dat["rec_c_3"]=="1"){?> checked="checked"<?}?> name="rec_c_3" class="rec_c"><label for="rec_c_3" class="nese">必須</label>
<input id="rec_4" type="text" value="<?=$dat["rec_4"]?>" class="textbox w300"><input type="checkbox" id="rec_c_4" value="1" <? if($dat["rec_c_4"]=="1"){?> checked="checked"<?}?> name="rec_c_4" class="rec_c"><label for="rec_c_4" class="nese">必須</label>
<input id="rec_5" type="text" value="<?=$dat["rec_5"]?>" class="textbox w300"><input type="checkbox" id="rec_c_5" value="1" <? if($dat["rec_c_5"]=="1"){?> checked="checked"<?}?> name="rec_c_5" class="rec_c"><label for="rec_c_5" class="nese">必須</label>
<input id="rec_6" type="text" value="<?=$dat["rec_6"]?>" class="textbox w300"><input type="checkbox" id="rec_c_6" value="1" <? if($dat["rec_c_6"]=="1"){?> checked="checked"<?}?> name="rec_c_6" class="rec_c"><label for="rec_c_6" class="nese">必須</label>
<input id="rec_7" type="text" value="<?=$dat["rec_7"]?>" class="textbox w300"><input type="checkbox" id="rec_c_7" value="1" <? if($dat["rec_c_7"]=="1"){?> checked="checked"<?}?> name="rec_c_7" class="rec_c"><label for="rec_c_7" class="nese">必須</label>
<input id="rec_8" type="text" value="<?=$dat["rec_8"]?>" class="textbox w300"><input type="checkbox" id="rec_c_8" value="1" <? if($dat["rec_c_8"]=="1"){?> checked="checked"<?}?> name="rec_c_8" class="rec_c"><label for="rec_c_8" class="nese">必須</label>

<div class="title_1">　プライバシーポリシー<button type="button" class="tmp_btn">下書き保存</button></div>
<span class="td_tag">　本文</span>
<textarea id="pg_1" class="textarea2 w560">
『○○』（以下，「当社」といいます。）は，本ウェブサイト上で提供するサービス（以下,「本サービス」といいます。）における，ユーザーの個人情報の取扱いについて，以下のとおりプライバシーポリシー（以下，「本ポリシー」といいます。）を定めます。
第1条　個人情報
「個人情報」とは，個人情報保護法にいう「個人情報」を指すものとし，生存する個人に関する情報であって，当該情報に含まれる氏名，生年月日，住所，電話番号，連絡先その他の記述等により特定の個人を識別できる情報及び容貌，指紋，声紋にかかるデータ，及び健康保険証の保険者番号などの当該情報単体から特定の個人を識別できる情報（個人識別情報）を指します。
第2条　個人情報の収集方法
当社は，ユーザーが利用登録をする際に氏名，生年月日，住所，電話番号，メールアドレス，銀行口座番号，クレジットカード番号，運転免許証番号などの個人情報をお尋ねすることがあります。また，ユーザーと提携先などとの間でなされたユーザーの個人情報を含む取引記録や決済に関する情報を,当社の提携先（情報提供元，広告主，広告配信先などを含みます。以下，｢提携先｣といいます。）などから収集することがあります。
第3条　個人情報の利用目的
当社が個人情報を収集・利用する目的は，以下のとおりです。 当社サービスの提供・運営のため
ユーザーからのお問い合わせに回答するため（本人確認を行うことを含む）
ユーザーが利用中のサービスの新機能，更新情報，キャンペーン等及び当社が提供する他のサービスの案内のメールを送付するため
メンテナンス，重要なお知らせなど必要に応じたご連絡のため
利用規約に違反したユーザーや，不正・不当な目的でサービスを利用しようとするユーザーの特定をし，ご利用をお断りするため
ユーザーにご自身の登録情報の閲覧や変更，削除，ご利用状況の閲覧を行っていただくため
</textarea>

<div class="title_1">　バナー<button type="button" class="tmp_btn">下書き保存</button></div>
<span class="td_tag">　TOPバナー詳細(1200px × 480px)</span>
<textarea id="bn_0" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["bn_0"]?></textarea>
<span class="td_tag">　サイドバナー詳細(600px × 150px)</span>
<textarea id="bn_1" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["bn_1"]?></textarea>



 
<div class="title_1">　使用コンテンツ<button type="button" class="tmp_btn">下書き保存</button></div>
<table class="table_3">
	<tr>
		<td>
		<div class="ck_title">CMSコンテンツ</div>
			<label for="ck_1" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_1" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_1"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>Notice</span>
				<span class="ques"><span class="ans">店舗からキャストへ連絡事項の告知をするためのものです。</span></span>
			</label>

			<label for="ck_2" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_2" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_2"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>EasyTalk</span>
				<span class="ques"><span class="ans">キャストが顧客へ営業メールを送るためのものです。</span></span>
			</label>

			<label for="ck_3" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_3" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_3"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>スケジュール</span>
				<span class="ques"><span class="ans">キャストの出勤日、時間を表示するためのものです。</span></span>
			</label>
		</td>

		<td>
			<div class="ck_title">サイト内ページ</div>
			<label for="ck_4" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_4" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_4"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>TOP挨拶</span>
				<span class="ques"><span class="ans">ページのTOPに挨拶の一文を入れるためのものです。</span></span>
			</label>
			<label for="ck_5" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_5" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_5"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>ニュース</span>
				<span class="ques"><span class="ans">イベントやキャストに関する様々なお知らせを告知するためのものです。</span></span>
			</label>

			<label for="ck_6" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_6" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_6"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>システム</span>
				<span class="ques"><span class="ans">料金など、お店のシステムを告知するためのものです。</span></span>
			</label>

			<label for="ck_7" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_7" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_7"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>キャストブログ</span>
				<span class="ques"><span class="ans">キャストがHIME-Karteより投稿するブログです。</span></span>
			</label>

			<label for="ck_8" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_8" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_8"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>スタッフブログ</span>
				<span class="ques"><span class="ans">スタッフが投稿するブログです。</span></span>
			</label>

			<label for="ck_9" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_9" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_9"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>アクセス</span>
				<span class="ques"><span class="ans">お店の住所、連絡先、MAPを表示します。</span></span>
			</label>

			<label for="ck_10" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_10" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_10"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>リクルート</span>
				<span class="ques"><span class="ans">キャストの求人受付です。</span></span>
			</label>

			<label for="ck_11" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_11" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_11"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>プライバシーポリシー</span>
				<span class="ques"><span class="ans">サイトとしての個人情報への取り組みを明記するためのものです。</span></span>
			</label>
		</td>

		<td>
			<div class="ck_title">システムコンテンツ</div>
			<label for="ck_12" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_12" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_12"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>SSL設定</span>
				<span class="ques"><span class="ans">サイトを暗号化し、安全なものにするためのものです。</span></span>
			</label>

			<label for="ck_13" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_13" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_13"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>アナリティクス</span>
				<span class="ques"><span class="ans">サイトへのアクセス状況を調べるためのものです。</span></span>
			</label>

			<label for="ck_14" class="ck_box0">
				<span class="ck_box1">
				<input id="ck_14" type="checkbox" class="ck_box2" value="1"  <? if($dat["ck_14"]=="1"){?> checked="checked"<?}?>>
				<span class="ck_box3"></span>
				</span>
				<span>サーチコンソール</span>
				<span class="ques"><span class="ans">検索評価の確認をするためのものです。</span></span>
			</label>

			<label for="ck_15" class="ck_box0">
				<span class="ck_box1">
					<input id="ck_15" type="checkbox" class="ck_box2" value="1" <? if($dat["ck_15"]=="1"){?> checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>ファビコン</span>
				<span class="ques"><span class="ans">ブラウザのタイトルタブに自身のアイコンを表示します。</span></span>
			</label>
		</td>
	</tr>
</table>


 
<div class="title_1">　有料オプション<button type="button" class="tmp_btn">下書き保存</button></div>

<span class="td_tag2">
	<label for="pay_c_0" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_0" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_0"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>ドメイン・ブラウザ設定 (登録＋10か月分)</span>
	</label>
	<span class="pay_price">10,000円</span>
</span>
<textarea id="pay_0" name="pay_0" class="textarea w560" placeholder="ご希望のドメインをご記載下さい。"><?=$dat["pay_0"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_1" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_1" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_1"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>TOPバナー追加(1200px × 480px)</span>
	</label>
	<span class="pay_price">8,000円</span>
</span>
<textarea id="pay_1" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["pay_1"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_2" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_2" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_2"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>TOPバナー追加(1200px × 480px)</span>
	</label>
	<span class="pay_price">8,000円</span>
</span>
<textarea id="pay_2" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["pay_2"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_3" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_3" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_3"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>TOPバナー追加(1200px × 480px)</span>
	</label>
	<span class="pay_price">8,000円</span>
</span>
<textarea id="pay_3" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["pay_3"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_4" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_4" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_4"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>サイドバナー詳細(600px × 150px)</span>
	</label>
	<span class="pay_price">4,000円</span>
</span>
<textarea id="pay_4" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["pay_4"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_5" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_5" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_5"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>サイドバナー詳細(600px × 150px)</span>
	</label>
	<span class="pay_price">4,000円</span>
</span>
<textarea id="pay_5" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["pay_5"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_6" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_6" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_6"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>サイドバナー詳細(600px × 150px)</span>
	</label>
	<span class="pay_price">4,000円</span>
</span>
<textarea id="pay_6" class="textarea w560" placeholder="イメージと用途（店舗イメージ、イベント、求人用など）をご記載下さい。"><?=$dat["pay_6"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_7" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_7" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_7"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>ページ追加</span>
	</label>
	<span class="pay_price">12,000円～</span>
</span>
<textarea id="pay_7" class="textarea w560" placeholder="希望されるページの詳細をご記載下さい。"><?=$dat["pay_7"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_8" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_8" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_8"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>出張撮影(東京/神奈川/千葉/埼玉　2時間)</span>
	</label>
	<span class="pay_price">20,000円</span>
</span>
<textarea id="pay_8" class="textarea w560" placeholder="希望される日時（曜日）、お時間帯をご記載下さい。"><?=$dat["pay_8"]?></textarea>

<span class="td_tag2">
	<label for="pay_c_9" class="ck_box0" style="width:400px;">
		<span class="ck_box1">
			<input id="pay_c_9" type="checkbox" class="ck_box2" value="1"  <? if($dat["pay_c_9"]=="1"){?> checked="checked"<?}?>>
			<span class="ck_box3"></span>
		</span>
		<span>ロゴ作成(単色　1200px × 1200px)</span>
	</label>
	<span class="pay_price">10,000円</span>
</span>
<textarea id="pay_9" class="textarea w560" placeholder="希望される色、イメージをご記載下さい。"><?=$dat["pay_9"]?></textarea>
</div>
</body>
</html>
