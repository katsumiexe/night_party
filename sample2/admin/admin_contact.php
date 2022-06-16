<?
$radio_list[1]="電話連絡済";
$radio_list[2]="メール返信済";
$radio_list[3]="LINE返信済";
$radio_list[4]="その他連絡済";
$radio_list[5]="返信不要";
$radio_list[6]="保留";

$s=0;

$pg		=$_POST["pg"];
if($pg<1) $pg=1;

$pg_st	=($pg-1)*30;
$pg_ed	=$pg_st+30;

$yet_ck	=$_POST["yet_ck"];
if(!$_POST["send"]){
	$yet_ck= 1;
}

if($yet_ck == 1){
	$app.=" AND staff IS NULL AND res_kind IS NULL";
}

$st_ck=$_POST["st_ck"];
if($st_ck){
	$st=$st_ck." 00:00:00";
	$app.=" AND date>='{$st}'";
}

$ed_ck=$_POST["ed_ck"];
if($ed_ck){
	$ed=$ed_ck." 00:00:00";
	$app.=" AND date<='{$ed}'";
}

$sql	 ="SELECT COUNT(list_id) AS cnt FROM ".TABLE_KEY."_contact_list";
$sql	.=" WHERE list_id>0";
$sql	.= $app;

$result = mysqli_query($mysqli,$sql);
$res	= mysqli_fetch_assoc($result);

$res_max=$res["cnt"];
$pg_max	=ceil($res["cnt"]/30);

if($pg_max<8){
	$pager_st=1;
	$pager_ed=$pg_max;

}elseif($pg<5){
	$pager_st=1;
	$pager_ed=7;

}elseif($pg_max-$pg<3){
	$pager_st=$pg-3;
	$pager_ed=$pg_max;

}else{
	$pager_st=$pg-3;
	$pager_ed=$pg+3;
}

if($pg>1){
	$pg_p=$pg-1;
}

if($pg<$pg_max){
	$pg_n=$pg+1;
}


$sql	 ="SELECT * FROM ".TABLE_KEY."_contact_list";
$sql	.=" WHERE list_id>0";
$sql	.= $app;
$sql	.= " LIMIT {$pg_st},30";

if($result = mysqli_query($mysqli,$sql)){
	while($row	= mysqli_fetch_assoc($result)){
		$dat[]=$row;
	}
}

var_dump($dat);

/*
$sql	 ="SELECT * FROM ".TABLE_KEY."_contact_table AS T";
$sql	.=" LEFT JOIN ".TABLE_KEY."_contact_list AS L ON T.id=L.type ";

$sql	.=" WHERE list_id>0";
$sql	.= $app;
$sql	.=" ORDER BY L.date DESC";
$sql	.=" LIMIT {$pg_st}, 20";

if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		$dat_id[$s]		=$res;

		$dat[$s][0]["res_radio"]	=$res["res_radio"];

		if($res["log_0_type"]>0){
			$dat[$s][0]["name"]		=$res["log_0_name"];
			$dat[$s][0]["log"]		=$res["log_0"];
			$dat[$s][0]["type"]		=substr($res["log_0_type"],0,1);
		}

		if($res["log_1_type"]>0){
			$dat[$s][1]["name"]		=$res["log_1_name"];
			$dat[$s][1]["log"]		=$res["log_1"];
			$dat[$s][1]["type"]		=substr($res["log_1_type"],0,1);
		}

		if($res["log_2_type"]>0){
			$dat[$s][2]["name"]		=$res["log_2_name"];
			$dat[$s][2]["log"]		=$res["log_2"];
			$dat[$s][2]["type"]		=substr($res["log_2_type"],0,1);
		}

		if($res["log_3_type"]>0){
			$dat[$s][3]["name"]		=$res["log_3_name"];
			$dat[$s][3]["log"]		=$res["log_3"];
			$dat[$s][3]["type"]		=substr($res["log_3_type"],0,1);
		}

		if($res["log_4_type"]>0){
			$dat[$s][4]["name"]		=$res["log_4_name"];
			$dat[$s][4]["log"]		=$res["log_4"];
			$dat[$s][4]["type"]		=substr($res["log_4_type"],0,1);
		}

		if($res["log_5_type"]>0){
			$dat[$s][5]["name"]		=$res["log_5_name"];
			$dat[$s][5]["log"]		=$res["log_5"];
			$dat[$s][5]["type"]		=substr($res["log_5_type"],0,1);
		}

		if($res["log_6_type"]>0){
			$dat[$s][6]["name"]		=$res["log_6_name"];
			$dat[$s][6]["log"]		=$res["log_6"];
			$dat[$s][6]["type"]		=substr($res["log_6_type"],0,1);
		}

		if($res["log_7_type"]>0){
			$dat[$s][7]["name"]		=$res["log_7_name"];
			$dat[$s][7]["log"]		=$res["log_7"];
			$dat[$s][7]["type"]		=substr($res["log_7_type"],0,1);
		}

		if($res["log_8_type"]>0){
			$dat[$s][8]["name"]		=$res["log_8_name"];
			$dat[$s][8]["log"]		=$res["log_8"];
			$dat[$s][8]["type"]		=substr($res["log_8_type"],0,1);
		}

		if($res["log_9_type"]>0){
			$dat[$s][9]["name"]		=$res["log_9_name"];
			$dat[$s][9]["log"]		=$res["log_9"];
			$dat[$s][9]["type"]		=substr($res["log_9_type"],0,1);
		}
		$s++;
	}
}
*/

?>
<style>

.contact_top{
	margin-left		:10px;
	height			:50px;
	width			:1080px;
	flex-basis		:1080px;
}

.contact_main{
	height			:200px;
	width			:1080px;
	flex-basis		:1080px;
	margin-left		:10px;
	margin-bottom	:20px;
	padding-bottom	:10px;
	border-bottom	:1px solid #202020;
}

.contact_table{
	margin			:0 10px 20px 0;
	border			:1px solid #303030;
	width			:600px;
	display			:inline-block;
	vertical-align	:top;
}

.contact_date{
	font-size		:14px;
	padding			:1px 5px;
	border-bottom	:2px solid #202020;
	font-weight		:600;
//	background		:#fafafa;
}

.contact_tag{
	display			:inline-block;
	font-size		:14px;
	margin-right	:5px;
}

.contact_table td{
	font-size		:14px;
	padding			:3px;
	border			:1px solid #303030;
}

.contact_td_l{
	width			:150px;
	background		:#e0e0e0;
	min-height		:20px;
}

.contact_td_r{
	width			:450px;
	background		:#fafafa;
}

.contact_td_r_in{
	display			:block;
	width			:450px;
	font-size		:14px;
	line-height		:20px;
}

.contact_area{
	width			:460px;
	height			:200px;
	resize			:none;
	padding			:10px;
	font-size		:14px;
	vertical-align	:top;
}
</style>
<script>
$(function(){ 
});
</script>
<header class="head">
<form id="main_form" method="post">
	<input id="pg" type="hidden" name="pg">
	<input type="hidden" name="send" value="1">
	<input type="hidden" name="menu_post" value="contact">
	<span class="event_tag" style="margin:10px 0">開始</span><input type="date" name="st_ck" class="w140" value="<?=$st_ck?>" style="margin:10px 10px 10px 0" autocomplete="off">
	<span class="event_tag" style="margin:10px 0 10px 10px">終了</span><input type="date" name="ed_ck" class="w140" value="<?=$ed_ck?>" style="margin:10px 10px 10px 0" autocomplete="off">

	<label for="webp_select" class="ribbon_use" >
		<span class="check2">
			<input id="webp_select" type="checkbox" class="ck0" value="1" name="yet_ck" <?if($yet_ck==1){?> checked="checked"<?}?>>
			<span class="check1"></span>
		</span>
		未対応のみ
	</label>
	<button  type="submit" class="event_reg_btn">検索</button>
</form>
<div class="pager">
<div id="pp<?=$pg_p?>" class="page_p pg_off">前へ</div>
<?for($s=$pager_st;$s<$pager_ed+1;$s++){?>
<?if($pg == $s){?>
<div class="page pg_on"><?=$s?></div>
<?}else{?>
<div id="pg<?=$s?>" class="page pg_off"><?=$s?></div>
<?}?>
<?}?>
<div id="nn<?=$pg_n?>" class="page_n pg_off">次へ</div>
</div>
</header>

<div class="top_page">(<?=$pg_st+1?> - <?=$pg_ed?> / <?=$res_max?>件)</div>
<div class="wrap" style="flex-wrap:wrap;">

	<?foreach($dat as $a1 => $a2){?>
		<div class="contact_top">
			<span class="contact_date"><?=$a2["date"]?></span>

			<?for($n=1;$n<7;$n++){?>
			<label for="rd<?=$a2["list_id"]?>_<?=$n?>" class="ck_free2">
				<span class="check2">
					<input id="rd<?=$a2["list_id"]?>_<?=$n?>" type="radio" name="radio<?=$a2["list_id"]?>" value="<?=$n?>" class="ck1" <?if($a2["res_kind"] ==$n){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<?=$radio_list[$n]?>
			</label>
			<?}?>
			<span class="contact_tag">担当：</span>
			<input id="staff<?=$a2["list_id"]?>" type="text" value="<?=$a2["staff"]?>" style="width:70px" name="staff">
			<button id="send<?=$a2["list_id"]?>" type="button" class="submit_btn contact_set">登録</button>
		</div>

		<div class="contact_main">
			<table class="contact_table">
				<?if($a2["q0"]){?>
					<tr><td class="contact_td_l"><?=$a2["q0"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a0"]?></div></td></tr>
				<? } ?>

				<?if($a2["q1"]){?>
					<tr><td class="contact_td_l"><?=$a2["q1"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a1"]?></div></td></tr>
				<? } ?>

				<?if($a2["q2"]){?>
					<tr><td class="contact_td_l"><?=$a2["q2"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a2"]?></div></td></tr>
				<? } ?>

				<?if($a2["q3"]){?>
					<tr><td class="contact_td_l"><?=$a2["q3"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a3"]?></div></td></tr>
				<? } ?>

				<?if($a2["q4"]){?>
					<tr><td class="contact_td_l"><?=$a2["q4"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a4"]?></div></td></tr>
				<? } ?>

				<?if($a2["q5"]){?>
					<tr><td class="contact_td_l"><?=$a2["q5"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a5"]?></div></td></tr>
				<? } ?>

				<?if($a2["q6"]){?>
					<tr><td class="contact_td_l"><?=$a2["q6"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a6"]?></div></td></tr>
				<? } ?>

				<?if($a2["q7"]){?>
					<tr><td class="contact_td_l"><?=$a2["q7"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a7"]?></div></td></tr>
				<? } ?>

				<?if($a2["q8"]){?>
					<tr><td class="contact_td_l"><?=$a2["q8"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a8"]?></div></td></tr>
				<? } ?>

				<?if($a2["q9"]){?>
					<tr><td class="contact_td_l"><?=$a2["q9"]?></td>
					<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2["a9"]?></div></td></tr>
				<? } ?>




			</table>
			<textarea id="log<?=$a2["list_id"]?>" class="contact_area"><?=$a2["res_log"]?></textarea>　
		</div>
	<? } ?>
</div>
