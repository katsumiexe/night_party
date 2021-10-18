<?php
include_once('./library/sql.php');
include_once('./library/inc_code.php');

/*
0　通常
1　休職
2　退職
3　停止
*/

$t_day=date("Ymd",$day_time);
$n_day=date("Ymd",$day_time+(86400*7));

$post_id=$_REQUEST["post_id"];
$sql="SELECT * FROM wp00000_cast WHERE id='{$post_id}' AND cast_status<2 LIMIT 1";
if($res = mysqli_query($mysqli,$sql)){
	$cast_data = mysqli_fetch_assoc($res);
	if (file_exists("./img/profile/{$cast_data["id"]}/0.jpg")) {
		$face_a="<img src=\"./img/profile/{$cast_data["id"]}/0.jpg?t={$tm}\" class=\"person_img_main\">";
		$face_b="<img id=\"i1\" src=\"./img/profile/{$cast_data["id"]}/0.jpg?t={$tm}\" class=\"person_img_sub\">";

		if (file_exists("./img/profile/{$cast_data["id"]}/1.jpg")) {
			$face_b.="<img id=\"i2\" src=\"./img/profile/{$cast_data["id"]}/1.jpg?t={$tm}\" class=\"person_img_sub\">";
		}

		if (file_exists("./img/profile/{$cast_data["id"]}/2.jpg")) {
			$face_b.="<img id=\"i3\" src=\"./img/profile/{$cast_data["id"]}/2.jpg?t={$tm}\" class=\"person_img_sub\">";
		}

		if (file_exists("./img/profile/{$cast_data["id"]}/3.jpg")) {
			$face_b.="<img id=\"i4\" src=\"./img/profile/{$cast_data["id"]}/3.jpg?t={$tm}\" class=\"person_img_sub\">";
		}

	}else{
		$face_a="<img src=\"./img/cast_no_image.jpg\" class=\"person_img_main\">";
	}


	$sql ="SELECT * FROM wp00000_sch_table";
	$sql.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$sch_time[$row["in_out"]][$row["time"]]	=$row["name"];
		}
	}

	$sql	 ="SELECT * FROM wp00000_schedule";
	$sql	.=" WHERE sche_date BETWEEN '{$t_day}' AND '{$n_day}'";
	$sql	.=" AND cast_id='{$post_id}'";
	$sql	.=" ORDER BY id ASC";

	if($res = mysqli_query($mysqli,$sql)){
		while($a0 = mysqli_fetch_assoc($res)){
			$sch[$a0["sche_date"]]=$a0;
		}
	}
	for($n=0;$n<7;$n++){
		$t_sch=date("Ymd",$day_time+(86400*$n));

		$tmp_s=$sch_time["in"][$sch[$t_sch]["stime"]];
		$tmp_e=$sch_time["out"][$sch[$t_sch]["etime"]];

		$list_day=substr($t_sch,4,2)."/".substr($t_sch,6,2);
		$list_week=date("w",strtotime($t_sch));

		if($tmp_s && $tmp_e){
			$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." (".$week[$list_week].")</td><td class=\"sche_r_".$list_week."\"><span class=\"sche_block1\">".$tmp_s."</span>－<span class=\"sche_block1\">".$tmp_e."</span></td>";
		}else{
			$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." (".$week[$list_week].")</td><td class=\"sche_r_".$list_week."\"><span class=\"sche_block1\">休み</span></td>";
		}
	}

	$sql ="SELECT sort,tag_name,tag_icon,log FROM wp00000_tag AS T";
	$sql.=" LEFT JOIN `wp00000_charm_sel` AS S ON T.id=S.list_id";
	$sql.=" WHERE T.del='0'";
	$sql.=" AND (S.cast_id='{$post_id}' OR S.cast_id='')";
	$sql.=" ORDER BY T.sort ASC";

	if($res = mysqli_query($mysqli,$sql)){
		while($a0 = mysqli_fetch_assoc($res)){
			$a0["log"]=str_replace("\n","<br>",$a0["log"]);
			$charm_table[]=$a0;
			$cnt_charm_table++;
		}
	}

	$sql ="SELECT id,title,style FROM wp00000_check_main";
	$sql.=" WHERE del='0'";
	$sql.=" ORDER BY sort ASC";

	if($res = mysqli_query($mysqli,$sql)){
		while($a1 = mysqli_fetch_assoc($res)){
			if($a1["style"] == 1){
				$check_ex[$a1["id"]]=1;
			}
			$check_main[]=$a1;
			$cnt_check_main++;
		}
	}

	$sql ="SELECT L.id, L.host_id, L.list_title, S.sel FROM wp00000_check_list AS L";
	$sql.=" LEFT JOIN `wp00000_check_sel` AS S ON L.id=S.list_id";
	$sql.=" AND del='0'";
	$sql.=" AND (cast_id IS NULL OR cast_id='{$post_id}')";
	$sql.=" ORDER BY host_id ASC, list_sort ASC, L.id ASC";

	if($res = mysqli_query($mysqli,$sql)){
		while($a1 = mysqli_fetch_assoc($res)){
	
		if($a1["sel"] == 1){
			$check_ex[$a1["host_id"]]=1;
		}
			$check_list[$a1["host_id"]][$a1["id"]]=$a1;
		}
	}

	$sql ="SELECT P.id,view_date, title, img, cast, genji,tag_name,tag_icon FROM wp00000_posts AS P";
	$sql.=" LEFT JOIN wp00000_cast AS C ON P.cast=C.id";
	$sql.=" LEFT JOIN wp00000_tag AS T ON P.tag=T.id";
	$sql.=" WHERE P.status=0";
	$sql.=" AND C.cast_status<4";
	$sql.=" AND view_date<='{$now}'";
	$sql.=" AND P.cast='{$post_id}'";
	$sql.=" ORDER BY view_date DESC";
	$sql.=" LIMIT 5";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			if (file_exists("./img/profile/{$row["cast"]}/0.webp")) {
				$row["face"]="./img/profile/{$row["cast"]}/0.webp";
				
			}elseif (file_exists("./img/profile/{$row["cast"]}/0.jpg")) {
				$row["face"]="./img/profile/{$row["cast"]}/0.jpg";

			}else{
				$row["face"]="./img/cast_no_image.jpg";
			}

			if ($row["img"]) {
				$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.png";			

			}else{
				$row["thumb"]="./img/blog_no_image.png";
			}

			$row["date"]=substr(str_replace("-",".",$row["view_date"]),0,10);
			$blog[]=$row;

			$cnt_blog++;
		}
	}
}

if(!$cast_data["id"]){
	$err="お探しのページはみつかりませんでした";
}
include_once('./header.php');
?>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<a href="./cast.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">CAST</span>
	</a>
<?if(!$err){?>
	<span class="footmark_icon"></span>
	<span class="footmark_icon"></span>
	<span class="footmark_text"><?=$cast_data["genji"]?></span>
<?}?>
</div>

<div class="person_main">
<?if($err){?>
	<span class="no_blog"><?=$err?></span>
<?}else{?>
	<div class="person_left">
		<div class="person_img_box">
			<?=$face_a?>
			<span class="person_img_top"></span>
		</div>
		<div class="person_img_list">
			<?=$face_b?>
		</div>

		<div class="person_left_blog">
			<div class="blog_title">Blog</div>
			<?for($s=0;$s<$cnt_blog+0;$s++){?>
				<a href="./article.php?post_id=<?=$blog[$s]["id"]?>" id="i<?=$b1?>" class="person_blog">
					<img src="<?=$blog[$s]["thumb"]?>" class="person_blog_img">
					<span class="person_blog_tag"><span class="person_blog_i"><?=$blog[$s]["tag_icon"]?></span><span class="person_blog_c"><?=$blog[$s]["tag_name"]?></span></span>
					<span class="person_blog_date"><?=$blog[$s]["date"]?></span>
					<span class="person_blog_title"><?=$blog[$s]["title"]?></span>
				</a>
			<?}?>

			<?if($cnt_blog == 0){?>
				<div class="person_blog">
					<span class="person_blog_no">まだありません</span>
				</div>
			<?}?>
		</div>
	</div>

	<div class="person_middle">
		<div class="prof_title">Profile</div>
		<table class="prof">
			<tr>
				<td class="prof_l">名前</td>
				<td class="prof_r"><?=$cast_data["genji"]?></td>
			</tr>
		<?for($n=0;$n<$cnt_charm_table+0;$n++){?>
			<?if($charm_table[$n]["tag_icon"] == 2){?>
				<tr><td class="prof_0" colspan="2"></td></tr>
				<tr><td class="prof_l2" colspan="2"><?=$charm_table[$n]["tag_name"]?></td></tr>
				<tr><td class="prof_r2" colspan="2"><?=$charm_table[$n]["log"]?></td></tr>
			<?}else{?>
				<tr>
				<td class="prof_l"><?=$charm_table[$n]["tag_name"]?></td>
				<td class="prof_r"><?=$charm_table[$n]["log"]?></td>
				</tr>
			<?}?>
		<?}?>
		</table>

		<?for($n=0;$n<$cnt_check_main+0;$n++){?>
			<?if($check_ex[$check_main[$n]["id"]]== 1){?>	
				<div class="check_title"><?=$check_main[$n]["title"]?></div>
				<div class="check_box">
					<?foreach($check_list[$check_main[$n]["id"]] as $a1 => $a2){?>


						<?if($check_main[$n]["style"]==1 || $check_list[$check_main[$n]["id"]][$a2["id"]]["sel"]== 1){?>
							<div class="check_set<?=$check_list[$check_main[$n]["id"]][$a2["id"]]["sel"]?>"><?=$a2["list_title"]?></div>
						<? } ?>
					<? } ?>
				</div>
			<?}?>
		<?}?>

		<div class="prof_title">Schedule</div>
		<table class="sche">
			<?=$list?>
		</table>
	</div>

	<div class="person_right">
		<div class="blog_title">Blog</div>
		<?for($s=0;$s<$cnt_blog+0;$s++){?>
			<a href="./article.php?post_id=<?=$blog[$s]["id"]?>" id="i<?=$b1?>" class="person_blog">
				<img src="<?=$blog[$s]["thumb"]?>" class="person_blog_img">
				<span class="person_blog_tag"><span class="blog_list_icon"><?=$blog[$s]["tag_icon"]?></span><span class="blog_list_tcomm"><?=$blog[$s]["tag_name"]?></span></span>
				<span class="person_blog_date"><?=$blog[$s]["date"]?></span>
				<span class="person_blog_title"><?=$blog[$s]["title"]?></span>
			</a>
		<?}?>
		<?if($cnt_blog == 0){?>
			<div class="person_blog">
				<span class="person_blog_no">まだありません</span>
			</div>
		<?}?>
	</div>
<?}?>
</div>
<?include_once('./footer.php'); ?>
