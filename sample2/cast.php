<?php 
include_once('./library/sql.php');
$sql  ="SELECT id, tag_name, tag_icon,sort FROM ".TABLE_KEY."_tag ";
$sql .=" WHERE tag_group='ribbon'";
$sql.=" AND del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$ribbon_sort[$row["sort"]]=$row["id"];
		$ribbon[$row["id"]]["name"]=$row["tag_name"];

		$tmp1=hexdec(substr($row["tag_icon"],1,2))+56;
		$tmp2=hexdec(substr($row["tag_icon"],3,2))+56;
		$tmp3=hexdec(substr($row["tag_icon"],5,2))+56;

		if($tmp1 > 255) $tmp1 =255;
		if($tmp2 > 255) $tmp2 =255;
		if($tmp3 > 255) $tmp3 =255;

		$tmp1=dechex($tmp1);
		$tmp2=dechex($tmp2);
		$tmp3=dechex($tmp3);

		$tmp="#".$tmp1.$tmp2.$tmp3;
	
		$ribbon[$row["id"]]["c1"]=$tmp;
		$ribbon[$row["id"]]["c2"]=$row["tag_icon"];
	}
}

$sql=" SELECT id, genji,ctime,ribbon_use,cast_ribbon,prm FROM ".TABLE_KEY."_cast";
$sql.=" WHERE cast_status<2";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";

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

			}elseif($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[1]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[1]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[1]]["c2"];

			}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[3]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[3]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[3]]["c2"];
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
		$cast_dat[$row["id"]]=$row;
	}
}
$inc_title="｜在籍キャスト一覧";
include_once('./header.php');
?>
</header>
<div class="main">
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
<article class="box_0_sub">
		<h2 class="box_title">
		<span class="title_main">CAST</span>
		<span class="title_sub">キャスト</span>
		<span class="title_0">
		<span class="title_u1"></span>
		<span class="title_u2"></span>
		<span class="title_d"></span>
		<span class="title_1"></span>
		<span class="title_2"></span>
		<span class="title_3"></span>
		<span class="title_4"></span>
		<span class="title_5"></span>
		<span class="title_6"></span>
		<span class="title_7"></span>
		<span class="title_8"></span>
		</span>
		</h2>
	<div class="main_b_in">
		<?if(is_array($cast_dat)){?>
			<? foreach($cast_dat as $b1 => $b2){?>
				<a href="./person.php?post_id=<?=$b2["id"]?>" id="i<?=$b1?>" class="main_b_1">
					<div class="main_b_1_1" style="background-image:url('<?=$b2["face"]?>')"></div>
					<span class="main_b_1_2_name"><?=$b2["genji"]?></span>
					<?if($b2["ribbon_name"]){?>
						<span class="main_b_1_ribbon">
							<span class="main_b_1_ribbon_2" style="border-color:<?=$b2["ribbon_c1"]?>;border-left-color	:transparent;"></span>
							<span class="main_b_1_ribbon_3" style="border-color:<?=$b2["ribbon_c1"]?>;border-right-color:transparent;"></span>
							<span class="main_b_1_ribbon_4"></span>
							<span class="main_b_1_ribbon_5"></span>
							<span class="main_b_1_ribbon_0" style="background:linear-gradient(<?=$b2["ribbon_c1"]?>,<?=$b2["ribbon_c2"]?>)"></span>
							<span class="main_b_1_ribbon_1"><?=$b2["ribbon_name"]?></span>
						</span>
					<?}?>
				</a>
			<? } ?>
		<? }else{ ?>
			<span class="no_blog">キャスト情報はありません</span>
		<? } ?>
	</div>
</article>
<?include_once('./footer.php'); ?>
