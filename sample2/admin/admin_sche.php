<?

$start_time	=$admin_config["start_time"];
$start_week	=$admin_config["start_week"];
$week=array("日","月","火","水","木","金","土");
/*
<input id="ck_b" type="checkbox" name="cl_b" class="ck_box" value="1"><label for="ck_b" class="ck_label">通常</label>
<input id="ck_c" type="checkbox" name="cl_c" class="ck_box" value="1"><label for="ck_c" class="ck_label">準備</label>
<input id="ck_d" type="checkbox" name="cl_d" class="ck_box" value="1"><label for="ck_d" class="ck_label">休職</label>
<input id="ck_e" type="checkbox" name="cl_e" class="ck_box" value="1"><label for="ck_e" class="ck_label">退職</label>
<input id="ck_f" type="checkbox" name="cl_f" class="ck_box" value="1"><label for="ck_f" class="ck_label">停止</label>
*/

$ck_date=$_POST["ck_date"];

if(!$ck_date) $ck_date=$day_8;
$tmp_d=strtotime($ck_date);

if($_POST["page"]=="n"){
	$tmp_d+=604800;

}elseif($_POST["page"]=="p"){
	$tmp_d-=604800;
}

$tmp_week=date("w",$tmp_d) - $start_week;
if($tmp_week<0) $tmp_week+=7;

$st_day		=date("Ymd",$tmp_d-($tmp_week)*86400);
$ed_day		=date("Ymd",$tmp_d-($tmp_week)*86400+518400);
$ck_date	=date("Y-m-d",$tmp_d-($tmp_week)*86400);


$cl_b=$_POST["cl_b"];
$cl_c=$_POST["cl_c"];
$cl_d=$_POST["cl_d"];
$cl_e=$_POST["cl_e"];
$cl_f=$_POST["cl_f"];

if(!$cl_b && !$cl_c && !$cl_d && !$cl_e && !$cl_f){
	$cl_b=1;
	$cl_c=1;
}

if($cl_b == 1){
	$app.=" OR ( cast_status =0 AND ctime<='{$ed_day}')";
}

if($cl_c == 1){
	$app.=" OR ( cast_status =0 AND ctime>'{$ed_day}')";
}

if($cl_d == 1){
	$app.=" OR cast_status =2";
}

if($cl_e == 1){
	$app.=" OR cast_status =3";
}

if($cl_f == 1){
	$app.=" OR cast_status =4";
}

$pg		=$_POST["pg"];
if($pg<1) $pg=1;

$pg_st	=($pg-1)*30;
$pg_ed	=$pg_st+30;
$read_ct=0;

$sql =" SELECT * FROM ".TABLE_KEY."_sch_table";
$sql .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_table[$row["in_out"]][$row["sort"]]=$row["time"];
	}
}

$sql =" SELECT id, ctime, genji,genji_kana, prm FROM ".TABLE_KEY."_cast";
$sql.=" WHERE (cast_status=99";
$sql.=$app;
$sql.=")";
$sql.=" AND del=0";
$sql.=" ORDER BY cast_sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($read_ct>=$pg_st && $read_ct<$pg_ed){
			if (file_exists("../img/profile/{$row["id"]}/0.webp")) {
				$row["face"]="../img/profile/{$row["id"]}/0.webp?t={$row["prm"]}";			

			}elseif (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
				$row["face"]="../img/profile/{$row["id"]}/0.jpg?t={$row["prm"]}";			

			}else{
				$row["face"]="../img/cast_no_image.jpg";			
			}
			$row["sch"]="休み";
			$cast_dat[$row["id"]]=$row;
		}
		$read_ct++;
	}
}


$sql ="SELECT cast_id, stime, etime, sche_date FROM ".TABLE_KEY."_schedule";
$sql.=" WHERE sche_date>='{$st_day}'";
$sql.=" AND sche_date<='{$ed_day}'";
$sql.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["stime"] && $row["etime"]){
			$stime[$row["cast_id"]][$row["sche_date"]]=$row["stime"];
			$etime[$row["cast_id"]][$row["sche_date"]]=$row["etime"];
	
		}else{
			$stime[$row["cast_id"]][$row["sche_date"]]="休み";
			$etime[$row["cast_id"]][$row["sche_date"]]="";
		}
	}
}


if($read_ct>0){
	$pg_max	=ceil($read_ct/30);
	$res_max=$read_ct;

}else{
	$pg_max	=0;
	$res_max=0;
}

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

if($pg_ed>$res_max){
	$pg_ed=$res_max;
}

?>
<style>
<!--
input[type=text]{
	height:30px;
}

input[type="checkbox"],input[type="radio"]{
	display:none;
}

td{
	border:1px solid #303030;
	background:#fafafa;
}

-->
</style>
<script>
$(function(){ 

});
</script>
<header class="head">
<form id="main_form" method="post">
<input type="hidden" name="menu_post" value="sche">
<input id="pg" type="hidden" name="pg">

<button id="p_week" type="button" class="sche_submit" style="margin:10px 5px 10px 10px;vertical-align:top;">前週</button>
<input id="sel_date" type="date" name="ck_date" value="<?=$ck_date?>" class="w140" style="margin:10px 1px;vertical-align:top;">

<button id="n_week" type="button" class="sche_submit" style="margin:10px 10px 10px 5px;vertical-align:top;">翌週</button>
<input id="page" type="hidden" value="" name="page">
<input type="hidden" value="sche" name="menu_post">

<div class="status_check">
<input id="ck_b" type="checkbox" name="cl_b" class="status_check_box" value="1"<?if($cl_b==1){?> checked="checked"<?}?>><label for="ck_b" class="status_check_label">通常</label>
<input id="ck_c" type="checkbox" name="cl_c" class="status_check_box" value="1"<?if($cl_c==1){?> checked="checked"<?}?>><label for="ck_c" class="status_check_label">準備</label>
<input id="ck_d" type="checkbox" name="cl_d" class="status_check_box" value="1"<?if($cl_d==1){?> checked="checked"<?}?>><label for="ck_d" class="status_check_label">休職</label>
<input id="ck_e" type="checkbox" name="cl_e" class="status_check_box" value="1"<?if($cl_e==1){?> checked="checked"<?}?>><label for="ck_e" class="status_check_label">退職</label>
<input id="ck_f" type="checkbox" name="cl_f" class="status_check_box" value="1"<?if($cl_f==1){?> checked="checked"<?}?>><label for="ck_f" class="status_check_label">停止</label>
</div>
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
<div class="wrap">
<table style="margin:5px 10px;">
	<tr>
		<td class="td_top w250" colspan="2">キャスト名</td>
		<?for($n=0;$n<7;$n++){?>
		<td class="td_top w120<?if($day_8 == date("Ymd",strtotime($st_day)+($n*86400))){ ?> back_now<? } ?>">
			<?=date("m年d月",strtotime($st_day)+($n*86400))?>
			[<?=$week[date("w",strtotime($st_day)+($n*86400))]?>]
		</td>
		<?}?>
	</tr>

<?foreach((array)$cast_dat as $a1=> $a2){?>
	<tr>
		<td style="width:70px" class=""><img src="<?=$a2["face"]?>" style="width:60px; height:80px;margin:5px;"></td>

		<td class="td_castname w160">
			<div class="td_castname_in">
			<?=$a2["genji"]?><br>
			[<?=$a2["genji_kana"]?>]
			</div>
			<button id="ch_<?=$a2["id"]?>" type="button" class="sche_submit">更新</button><button id="rs_<?=$a1?>" type="button" class="sche_reset">RESET</button>
		</td>
		<?for($n=0;$n<7;$n++){?>
			<?
				$tmp_day=date("Ymd",strtotime($st_day)+($n*86400));
				if(!$stime[$a2["id"]][$tmp_day]) $stime[$a2["id"]][$tmp_day]="休み";
			?>

			<td class="td_inout w120<?if($day_8 == $tmp_day){ ?> line_now<? } ?> <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>">
				<div class="box_inout">
					<span class="tag_inout">入</span>
					<select id ="s_<?=$a2["id"]?>_<?=$n?>" class="sel_inout" <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>>
					<option value="休み" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>休み</option>
						<?foreach($sch_table["in"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $stime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=substr($b2,0,2)?>:<?=substr($b2,2,2)?></option>
						<?}?>
					</select>
					<input type="hidden" id="hs_<?=$a2["id"]?>_<?=$n?>" value="<?=$stime[$a2["id"]][$tmp_day]?>">
				</div>
				<div class="box_inout">
					<span class="tag_inout">退</span>
					<select id ="e_<?=$a2["id"]?>_<?=$n?>" class="sel_inout" <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>>
						<option value="" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>　</option>
						<?foreach($sch_table["out"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $etime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=substr($b2,0,2)?>:<?=substr($b2,2,2)?></option>
						<?}?>
					</select>
					<input type="hidden" id="he_<?=$a2["id"]?>_<?=$n?>" value="<?=$etime[$a2["id"]][$tmp_day]?>">
				</div>
				<input type="hidden" id="d_<?=$a2["id"]?>_<?=$n?>" value="<?=$tmp_day?>">

			</td>
		<?}?>
	</tr>
<?}?>
</table>
</div>
