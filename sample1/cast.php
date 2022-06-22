<?php 
include_once('./library/sql.php');
$sql  ="SELECT id, tag_name, tag_icon,sort FROM ".TABLE_KEY."_tag ";
$sql .=" WHERE tag_group='ribbon'";
$sql.=" AND del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$ribbon_sort[$row["sort"]]=$row["id"];
		$ribbon[$row["id"]]["name"]=$row["tag_name"];

		$tmp=hexdec(str_replace("#","",$row["tag_icon"]));
		$tmp+=2631720;
		$tmp=dechex($tmp);
	
		$ribbon[$row["id"]]["c1"]="#".$tmp;
		$ribbon[$row["id"]]["c2"]=$row["tag_icon"];
	}
}

$sql ="SELECT * FROM ".TABLE_KEY."_sch_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_time[$row["in_out"]][$row["time"]]	=$row["name"];
	}
}

$sql=" SELECT id, genji,ctime,ribbon_use,cast_ribbon,prm FROM ".TABLE_KEY."_cast";
$sql.=" WHERE cast_status=0";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";
$sql.=" LIMIT 30";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($admin_config["ribbon"] ==1){
			if($ribbon[$row["cast_ribbon"]]["name"]){
				$row["ribbon_name"]	=$ribbon[$row["cast_ribbon"]]["name"];
				$row["ribbon_c1"]	=$ribbon[$row["cast_ribbon"]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$row["cast_ribbon"]]["c2"];

			}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[2]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[2]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[2]]["c2"];

			}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[3]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[3]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[3]]["c2"];

			}elseif($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[1]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[1]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[1]]["c2"];
			}
		}

		if (file_exists("./img/profile/{$row["id"]}/0.webp") && $admin_config["webp_select"] == 1) {
			$row["face"]="./img/profile/{$row["id"]}/0.webp?t={$row["prm"]}";			

		}elseif (file_exists("./img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["id"]}/0.jpg?t={$row["prm"]}";

		}else{
			$row["face"]="./img/cast_no_image.jpg";			
		}
		$row["sch"]		="休み";


$sql=" SELECT stime, etime, cast_id FROM ".TABLE_KEY."_schedule AS S";
$sql.=" WHERE sche_date='{$day_8}'";
$sql.=" AND cast_id='{$row["id"]}'";
$sql.=" ORDER BY S.id DESC";
$sql.=" LIMIT 1";

if($result2 = mysqli_query($mysqli,$sql)){
	while($row2 = mysqli_fetch_assoc($result2)){
		if($row2["stime"] && $row2["etime"]){
			$row["sch"]="{$sch_time["in"][$row2["stime"]]} － {$sch_time["out"][$row2["etime"]]}";

		}else{
			$row["sch"]="休み";
		}
	}
}
		$cast_dat[$row["id"]]=$row;
	}
}

$inc_title="｜在籍キャスト一覧";
include_once('./header.php');

?>
<script>
var BLOCK=0;
var C_Page=0;
let VwBase	=$(window).width()/100;

$(function(){ 
	$(window).scroll(function() {
		var S=$(window).scrollTop();
		var H=$('.main_d').height();
		if(H - (VwBase * 100)<S && BLOCK == 0){
			C_Page++;
			BLOCK=1;
			$.post({
				url:"./post/cast_hist.php",
				data:{
					'page'		:C_Page,
				},

			}).done(function(data, textStatus, jqXHR){
				$('.main_d').append(data);
				BLOCK=0;

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}


	});
});

</script>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">CAST</span>
	</div>
</div>
<div class="main_d">
<? foreach($cast_dat as $b1=> $b2){?>
	<a href="./person.php?post_id=<?=$b1?>" id="i<?=$b1?>" class="main_d_1">
		<div class="main_d_1_1" style="background-image:url('<?=$b2["face"]?>')"></div>

		<div class="main_d_1_2">
			<span class="main_b_1_2_h"></span>
			<span class="main_b_1_2_f f_tr"></span>
			<span class="main_b_1_2_f f_tl"></span>
			<span class="main_b_1_2_f f_br"></span>
			<span class="main_b_1_2_f f_bl"></span>

			<span class="main_d_1_2_name"><?=$b2["genji"]?></span>
			<span class="main_d_1_2_sch"><?=$b2["sch"]?></span>
		</div>

		<?if($b2["ribbon_name"]){?>
			<span class="main_b_1_ribbon" style="background:linear-gradient(<?=$b2["ribbon_c1"]?>,<?=$b2["ribbon_c2"]?>);box-shadow	:0 -5px 0 <?=$b2["ribbon_c1"]?>,0 5px 0 <?=$b2["ribbon_c2"]?>;"><?=$b2["ribbon_name"]?></span>
		<?}?>
	</a>
<? } ?>
</div>
<?include_once('./footer.php'); ?>
