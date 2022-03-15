<?php
include_once('./library/sql.php');

$sql="SELECT * FROM wp00000_contents WHERE page='recruit' AND status='0' ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($raw= mysqli_fetch_assoc($result)){
		$raw["contents"]=str_replace("\n","<br>",$raw["contents"]);

		if($raw["category"] == "list"){
			$dat_list[$raw["sort"]]=$raw;

		}else{
			$dat_config[$raw["category"]]=$raw;
		}
	}
}

$ck_tg["1"]="<span class=\"nec\">※必須項目</span>";
$ck_jq["1"]="nec_ck";
$ck_re["1"]="required";

if($dat_config["form"]){
	$sql="SELECT * FROM wp00000_contact_table";
	$sql.=" WHERE id='{$dat_config["form"]["contents_key"]}'";

	if($result = mysqli_query($mysqli,$sql)){
		$c_form= mysqli_fetch_assoc($result);
	}

	$form_dat="<div class=\"recruit_contact_title\">◆お問い合わせ◆</div>";
	$form_dat.="<div class=\"recruit_contact_box\">";
	for($n=1;$n<11;$n++){
		$tmp_nm="log_{$n}_name";

		if($c_form[$tmp_nm]){
			$tmp_pt=substr($c_form["log_".$n."_type"],0,1);
			$tmp_ck=substr($c_form["log_".$n."_type"],-1,1);

			$form_dat.="<div class=\"contact_tag\">{$c_form[$tmp_nm]}{$ck_tg[$tmp_ck]}</div><span id=\"err{$n}\" class=\"contact_err\">必須項目です</span>";
			$form_p.="<div class=\"contact_p_tag\">{$c_form[$tmp_nm]}</div>";

			if($tmp_pt== 1){//text
				$form_dat.="<input id=\"contact{$n}\" type=\"text\" name=\"contact{$n}\" class=\"contact_list contact {$ck_jq[$tmp_ck]}\" autocomplete=\"off\" {$ck_re["1"]}>";
				$form_p.="<div id=\"pcontact{$n}\" class=\"contact_p\"></div>";

			}elseif($tmp_pt== 2){//mail
				$form_dat.="<input id=\"contact{$n}\" type=\"url\" name=\"contact{$n}\" class=\"contact_list contact v_mail {$ck_jq[$tmp_ck]}\" autocomplete=\"off\" {$ck_re["1"]}>";
				$form_p.="<div id=\"pcontact{$n}\" class=\"contact_p\"></div>";

			}elseif($tmp_pt== 3){//number
				$form_dat.="<input id=\"contact{$n}\" type=\"number\" inputmode=\"numeric\" name=\"contact{$n}\" class=\"contact_list contact {$ck_jq[$tmp_ck]}\" autocomplete=\"off\" {$ck_re["1"]}>";
				$form_p.="<div id=\"pcontact{$n}\" class=\"contact_p_num\"></div>";

			}elseif($tmp_pt== 4){//comm
				$form_dat.="<textarea id=\"contact{$n}\" name=\"contact{$n}\" class=\"contact_list contact_area {$ck_jq[$tmp_ck]}\" autocomplete=\"off\" size=\"400\" {$ck_re["1"]}></textarea>";
				$form_p.="<div id=\"pcontact{$n}\" class=\"contact_p_area\"></div>";
			}
		}
	}
	$form_p.="<div class=\"contact_p_ck\">送信します。よろしいですか</div>";
	$form_p.="<button id=\"recruit_ok\" type=\"button\" class=\"recruit_send2\" >送信</button>　<button id=\"recruit_ng\" type=\"button\" class=\"recruit_send2\" >戻る</button><br><br>";
	$form_dat.="<button id=\"recruit_send\" type=\"button\" class=\"recruit_send\" >送信</button>";
	$form_dat.="</div>";
}

$inc_title="｜キャスト募集";
include_once('./header.php');
?>
<script>
var PostList=[];

$(function(){ 
	$('#recruit_send').on('click',function(){
		var Err="";

		$('.contact_list').each(function() {
			Tmp=$(this).attr('id');
			$('#p'+Tmp).text($(this).val());
	
			if($(this).val()  == '' && $(this).hasClass('nec_ck')){
				$(this).prev().addClass('err_on');
				Err=1;
			}
		});	

		if(Err == ""){
			$('.recruit_pop').fadeIn(200);
		}
	});

	$('.nec_ck').on('keyup',function(){
		$(this).prev().removeClass('err_on');
	});


	$('#recruit_ok').on('click',function(){
		$('.contact_list').each(function() {
			Tmp=$(this).attr('id').replace('contact','');
			PostList[Tmp]=$(this).val();
		});

		$.post({
			url:"./post/contact_send.php",
			data:{
				'id':'<?=$dat_config["form"]["contents_key"]?>',
				'dat[]':PostList,

			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('.recruit_pop_in').fadeOut(0).delay(3100).fadeIn(0);
			$('.recruit_pop_in2').fadeIn(0).delay(3100).fadeOut(0);
			$('.recruit_pop').delay(2000).fadeOut(1000);

			$('.contact_list').val();

		});
	});

	$('#recruit_ng').on('click',function(){
		$('.recruit_pop').fadeOut(200);
	});
});
</script>
<style>
</style>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">RECRUIT</span>
	</div>
</div>
<?if(!$dat_config){?>
<div class="main_e">
	<div class="main_e_in">
		<span class="main_e_f c_tr"></span>
		<span class="main_e_f c_tl"></span>
		<span class="main_e_f c_br"></span>
		<span class="main_e_f c_bl"></span>

		<div class="corner_in box_in_1"></div>
		<div class="corner_in box_in_2"></div>
		<div class="corner_in box_in_3"></div>
		<div class="corner_in box_in_4"></div>
		<span class="sys_box">情報はありません</span><br>
	</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<?}else{?>

<?if (file_exists("./img/page/contents/recruit_top.webp") && $admin_config["webp_select"] == 1) {?>
	<img src="./img/page/contents/recruit_top.webp?t=<?=$dat_config["top"]["prm"]?>" class="rec_img">

<?}elseif (file_exists("./img/page/contents/recruit_top.jpg")) {?>
	<img src="./img/page/contents/recruit_top.jpg?t=<?=$dat_config["top"]["prm"]?>" class="rec_img">

<?}elseif (file_exists("./img/page/contents/recruit_top.png")) {?>
	<img src="./img/page/contents/recruit_top.png?t=<?=$dat_config["top"]["prm"]?>" class="rec_img">
<?}?>

<div class="main_e">
	<div class="main_e_in">
		<span class="main_e_f c_tr"></span>
		<span class="main_e_f c_tl"></span>
		<span class="main_e_f c_br"></span>
		<span class="main_e_f c_bl"></span>
		<div class="corner_in box_in_1"></div>
		<div class="corner_in box_in_2"></div>
		<div class="corner_in box_in_3"></div>
		<div class="corner_in box_in_4"></div>

		<span class="sys_box_ttl"><?=$dat_config["top"]["title"]?></span><br>
		<span class="sys_box_log"><?=$dat_config["top"]["contents"]?></span><br>
	</div>
	<div class="corner box_1"></div>
	<div class="corner box_2"></div>
	<div class="corner box_3"></div>
	<div class="corner box_4"></div>
</div>

<?foreach($dat_list as $a2){?>
	<div class="rec">
		<div class="rec_l"><?=$a2["title"]?></div>
		<div class="rec_r"><?=$a2["contents"]?></div>
	</div>
<?}?>

<div class="contact_box">
	<?if($dat_config["tel"]["contents_key"]){?>
	<?$dat_config["tel"]["contents_key"]=str_replace("-","<span>-</span>",$dat_config["tel"]["contents_key"])?>
		<div class="recruit_contact r_tel">
			<span class="contact_icon"></span>
			<span class="contact_comm">電話</span>
			<span class="contact_no"><?=$dat_config["tel"]["contents_key"]?></span>
		</div>
	<?}?>

	<?if($dat_config["line"]["contents_key"]){?>
		<div class="recruit_contact r_line">
			<span class="contact_icon"></span>
			<span class="contact_comm">LINE</span>
			<span class="contact_no"><?=$dat_config["line"]["contents_key"]?></span>
		</div>
	<?}?>
</div>
<?=$form_dat?>
<?}?>


<div class="recruit_pop">
	<div class="recruit_pop_in"><?=$form_p?></div>
	<div class="recruit_pop_in2">
		送信しました。<br>
		折り返し担当スタッフより連絡致します。<br>
	</div>
</div>
<?include_once('./footer.php'); ?>
