<?

$c_s=$_POST["c_s"] +0;

if($c_s !=1){
	$c_s=0;
}

$s=0;
$pg		=$_POST["pg"];
if($pg<1) $pg=1;

$pg_st	=($pg-1)*30;
$pg_ed	=$pg_st+30;

$st_ck=$_POST["st_ck"];
if($st_ck){
	$st=$st_ck." 00:00:00";
	$app.=" AND date>='{$st}'";
}

if($c_s ==0){
	$cl_b=$_POST["cl_b"];
	$cl_c=$_POST["cl_c"];
	$cl_d=$_POST["cl_d"];
	$cl_e=$_POST["cl_e"];
	$cl_f=$_POST["cl_f"];

	if(!$cl_b && !$cl_c && !$cl_d && !$cl_e && !$cl_f){
		$cl_b=1;
		$cl_c=1;
	}

	$sql	 ="SELECT id,staff_id,genji,genji_kana, cast_sort, C.del, `group`, ctime, login_id, login_pass, cast_status,name,kana,cast_ribbon, S.mail, C.prm FROM wp00000_staff AS S";
	$sql	.=" INNER JOIN wp00000_cast AS C ON S.staff_id=C.id";
	$sql	.=" WHERE id IS NOT NULL";
	$sql	.=" AND cast_status<5";
	$sql	.=" AND S.del=0";
	$sql	.=" AND C.del=0";
	$sql	.=" ORDER BY cast_sort ASC";

	if($rowult = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($rowult)){
			if(
				($cl_b == 1 && $row["cast_status"] == 0 && $row["ctime"]<=$day_8) || 
				($cl_c == 1 && $row["cast_status"] == 0 && $row["ctime"]>$day_8) || 
				($cl_d == 1 && $row["cast_status"] == 2) || 
				($cl_e == 1 && $row["cast_status"] == 3) || 
				($cl_f == 1 && $row["cast_status"] == 4)
			){

				if (file_exists("../img/profile/{$row["id"]}/0_s.webp")) {
					$row["face"]="../img/profile/{$row["id"]}/0_s.webp?t={$row["prm"]}";

				}elseif (file_exists("../img/profile/{$row["id"]}/0_s.jpg")) {
					$row["face"]="../img/profile/{$row["id"]}/0_s.jpg?t={$row["prm"]}";			

				}else{
					$row["face"]="../img/cast_no_image.jpg";			
				}

				if($row["cast_status"]==0 && $row["ctime"]>$day_8){
					$row["cast_status"]=1;
				}

				if($row["login_id"] && $row["login_pass"]){
					$row["login"]=1;
				}
				$set[$row["staff_id"]]=1;
				$dat[]=$row;
				$count_dat++;
			}
		}
	}

}else{
	$sql	 ="SELECT id, staff_id, name, kana, mail, tel, C.del, `group` FROM wp00000_staff AS S";
	$sql	.=" LEFT JOIN wp00000_cast AS C ON S.staff_id=C.id";
	$sql	.=" WHERE S.del=0";
	$sql	.=" ORDER BY staff_id DESC";
	$sql	.=" LIMIT {$pg_st}, 30";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["del"] === 0){
				$row["c_s"]="CAST";			
			}else{
				$row["c_s"]="STAFF";
			}

			$dat[]=$row;
			$count_dat++;
		}
	}
}

$pg_st++;
if(!$count_dat){
	$pg_st=0;
	$pg_ed=0;

}else if($pg_ed>$count_dat){
	$pg_ed=$count_dat;


}


$sql	 ="SELECT * FROM wp00000_tag";
$sql	.=" WHERE del=0";
$sql	.=" and tag_group='cast_group' OR tag_group='ribbon'";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$group[$row["tag_group"]][$row["id"]]=$row["tag_name"];
	}
}

/*
$sql	 ="SELECT COUNT(C.id) AS cnt FROM wp00000_staff AS S";
$sql	.=" INNER JOIN wp00000_cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE (cast_status IS NULL";
$sql	.=$app_set;
$sql	.=")";
$sql	.=" AND id IS NOT NULL";
$sql	.=" AND cast_status<5";
$sql	.=" AND S.del=0";
$sql	.=" AND C.del=0";

$result = mysqli_query($mysqli,$sql);
$res	= mysqli_fetch_assoc($result);

$res_max=$res["cnt"];
$pg_max	=ceil($res["cnt"]/20);
if($pg_ed>$res_max){
	$pg_ed = $res_max;
}
*/

if($set){
	$pg_max	=ceil(count($set)/30);
	$res_max=count($set);

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
	padding:5px;
}



#sel_staff,#sel_cast{
}

#staff_l{
	border-radius:10px 0 0 10px;
	margin:10px 0 10px 10px;
}

#cast_l{
	border-radius:0 10px 10px 0;
	margin:10px 10px 10px 0;
}

.c_s_box{
	display				:inline-block;
	height				:30px;
	line-height			:30px;
	width				:180px;
	font-size			:0;
	color				:#fafafa;
	text-align			:left;
	margin 0 50px;
}

.c_s_btn{
	display				: inline-block;
	height				:30px;
	line-height			:30px;
	width				:80px;
	font-size			:16px;
	text-align			:center;
	background			:#cccccc;
	color				:#fafafa;
}

.on_1{
	background:#0000c0;
}

.on_2{
	background:#c00000;
}

.ck_off:checked + label{
	background		:linear-gradient(#c0c0f0,#8080ff);
}


.sel_status{
	display			:inline-block;
	background		:#d0d0d0;
	width			:80px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	border-radius	:5px;
	color			:#fafafa;
	font-size		:18px;
	font-weight		:600;
	text-align		:center;
}

.table_title{
	background		:linear-gradient(#e0e0e0,#d0d0d0);
	padding			:5px;
	font-size		:14px;
}

.icon{
	font-family:at_icon;
}

.box_sort{
	width		:35px;
	text-align	:right;
	padding		:3px;
	margin		:0 auto;
}
.td_staff{
	height		:40px;
	line-height	:40px;
	padding		:0 5px;
}
-->
</style>
<script>

$(function(){ 
	FS=$('#p_sort<?=$pg_st?>').val();
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

	$('.box_sort').on('change',function(){
		Base=$(this).attr('id').replace('s_box','');
		Val=$(this).val();

		if($('#ck_b').prop('checked')){
			var ck_B=1;
		}else{
			var ck_B=0;
		}

		if($('#ck_c').prop('checked')){
			var ck_C=1;
		}else{
			var ck_C=0;
		}

		if($('#ck_d').prop('checked')){
			var ck_D=1;
		}else{
			var ck_D=0;
		}

		if($('#ck_e').prop('checked')){
			var ck_E=1;
		}else{
			var ck_E=0;
		}

		if($('#ck_f').prop('checked')){
			var ck_F=1;
		}else{
			var ck_F=0;
		}

		if(Val==0){
			Val=1;
		}else if(Val > <?=$count_dat?>){
			Val = <?=$count_dat?>;
		}

		if(Base != Val){
			var FS=$(".tr").first().children('.td_sort').attr('id').replace('d_sort','');
			$.ajax({
				url:'./post/admin_sort.php',
				type: 'post',
				data:{
					'base':Base,
					'sort':Val,
					'pg_st':'<?=$pg_st-1?>',
					'group':"box_sort",
					'cl_b':ck_B,
					'cl_c':ck_C,
					'cl_d':ck_D,
					'cl_e':ck_E,
					'cl_f':ck_F,
					'fs':FS,
				},
			}).done(function(data, textStatus, jqXHR){
				console.log(data);
				$('#staff_sort').html(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}
	});
});
</script>


<header class="head">
<form id="main_form" method="post">
<input type="hidden" name="menu_post" value="staff">
<input id="pg" type="hidden" name="pg">
<input type="hidden" name="send" value="1">
<input id="sel_staff" value="1" type="radio" name="c_s" class="sel_radio" <?if($c_s==1){?> checked="checked"<?}?>><label id="staff_l" for="sel_staff" class="c_s_btn<?if($c_s==1){?> on_1<?}?>">STAFF</label>
<input id="sel_cast" value="0" type="radio" name="c_s" class="sel_radio" <?if($c_s==0){?> checked="checked"<?}?>><label id="cast_l" for="sel_cast" class="c_s_btn<?if($c_s==0){?> on_2<?}?>">CAST</label>
<?if($c_s == 0){?>
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
<div class="top_page">(<?=$pg_st?> - <?=$pg_ed?> / <?=$res_max?>件)</div>
<div class="wrap">
<table style="margin:5px 10px;">
<thead>
	<tr>
		<td class="td_top w40">替</td>
		<td class="td_top w40">順</td>
		<td class="td_top w50"></td>
		<td class="td_top w250">源氏名[フリガナ]</td>
		<td class="td_top w100">ID</td>
		<td class="td_top w100">Staff Code</td>
		<td class="td_top w100">入店日</td>
		<td class="td_top w80">グループ</td>
		<td class="td_top w80">状態</td>
		<td class="td_top w80">タグ</td>
		<td class="td_top w60">詳細</td>
	</tr>
</thead>
<tbody id="staff_sort" class="list_sort">
<?
for($n=0;$n<$count_dat;$n++){
if($set[$dat[$n]["staff_id"]]){
$h++;
if($h>=$pg_st && $h-1<$pg_ed){
?>
	<tr id="sort_item<?=$dat[$n]["staff_id"]?>" class="tr b<?=$dat[$n]["cast_status"]?>">
		<input id="p_sort<?=$h?>" type="hidden" value="<?=$dat[$n]["cast_sort"]?>">
		<td class="td_sort handle w40"></td>
		<td class="w40"><input id="s_box<?=$h?>" type="text" value="<?=$h?>" class="box_sort"></td>
		<td class="w50"><img src="<?=$dat[$n]["face"]?>" style="width:48px; height:64px;"></td>
		<td class="w140"><span class="st_name"><?=$dat[$n]["genji"]?></span><br>[<?=$dat[$n]["genji_kana"]?>]</td>
		<td class="w100">
			<?=$dat[$n]["login_id"]?><br>
			<button type="button" class="staff_hime">HIMEカルテ</button>
			<input type="hidden" value="<?=$dat[$n]["login"]?>">
			<input id="ml<?=$dat[$n]["staff_id"]?>" type="hidden" value="<?=$dat[$n]["mail"]?>">
		</td>
		<td class="w100"><?=$dat[$n]["id"]?></td>
		<td class="w100"><?=$dat[$n]["ctime"]?></td>
		<td class="w80"><?=$group["cast_group"][$dat[$n]["group"]]?></td>
		<td class="w80"><?=$cast_status_select[$dat[$n]["cast_status"]]?></td>
		<td class="w80"><?=$group["ribbon"][$dat[$n]["cast_ribbon"]]?></td>

		<td class="w60" style="position:relative; text-align:center;">
			<form method="post" style="margin-block-end: 0;">
				<button type="submit" class="staff_submit">詳細</button>
				<input type="hidden" value="staff_fix" name="menu_post">
				<input type="hidden" name="staff_id" value="<?=$dat[$n]["staff_id"]?>">
			</form>
		</td>
	</tr>
<?}?>
<?}else{?>
	<tr id="sort_item<?=$dat[$n]["staff_id"]?>" class="tr b<?=$dat[$n]["cast_status"]?>" style="display:none;">
		<td id="d_sort<?=$dat[$n]["cast_sort"]?>"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
<?}?>
<?}?>
</tbody>
</table>
<? }else{ ?>
</form>
</header>

<div class="wrap">
<table>
<thead>
<tr>
<td class="td_top w40">順</td>
<td class="td_top w100">ID</td>
<td class="td_top w140">名前</td>
<td class="td_top w80">所属</td>
<td class="td_top w80">グループ</td>
<td class="td_top w140">アドレス</td>
<td class="td_top w60">変更</td>
</tr>
</thead>
<tbody class="list_sort">
<?for($n=0;$n<$count_dat;$n++){?>
<tr class="tr b<?=$dat[$n]["cast_status"]?>">
	<td class="td_staff" style="text-align:right;"><?print($n+1);?></td>
	<td class="td_staff"><?=$dat[$n]["staff_id"]?></td>
	<td class="td_staff"><?=$dat[$n]["name"]?></td>
	<td class="td_staff"><?=$dat[$n]["c_s"]?></td>
	<td class="td_staff"><?=$group["cast_group"][$dat[$n]["group"]]?></td>

	<td class="td_staff"><?=$dat[$n]["mail"]?></td>
	<td class="td_staff" style="position:relative; text-align:center;">
		<form method="post" style="margin:0;">
			<button type="submit" class="staff_submit" style="margin:5px auto;">変更</button>
			<input type="hidden" value="staff_fix" name="menu_post">
			<input type="hidden" name="staff_id" value="<?=$dat[$n]["staff_id"]?>">
		</form>
	</td>
</tr>
<?}?>
</tbody>
</table>
<? } ?>
</div>
