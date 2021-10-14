<?php
include_once('./library/sql.php');
include_once('./library/inc_code.php');

$cast_list	=$_REQUEST["cast_list"];
$tag_list	=$_REQUEST["tag_list"];
$post_id	=$_REQUEST["post_id"];

if($cast_list){
	$article=$cast_list;
	$category=1;

}elseif($tag_list){
	$article=$tag_list;
	$category=2;
}

$sql ="SELECT view_date, title, log, img, img_del, cast, genji,tag_name,tag_icon FROM wp00000_posts AS P";
$sql.=" LEFT JOIN wp00000_cast AS C ON P.cast=C.id";
$sql.=" LEFT JOIN wp00000_tag AS T ON P.tag=T.id";
$sql.=" WHERE P.status=0";
$sql.=" AND C.cast_status<4";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND P.id='{$post_id}'";

if($result = mysqli_query($mysqli,$sql)){
	$blog = mysqli_fetch_assoc($result);

	if (file_exists("./img/profile/{$blog["cast"]}/0.webp")) {
		$blog["face"]="./img/profile/{$blog["cast"]}/0.webp";			

	}elseif (file_exists("./img/profile/{$blog["cast"]}/0.jpg")) {
		$blog["face"]="./img/profile/{$blog["cast"]}/0.jpg";			

	}else{
		$blog["face"]="./img/cast_no_image.jpg";			
	}

	if ($blog["img"] && $blog["img_del"]==0) {
		$blog["thumb"]="./img/profile/{$blog["cast"]}/{$blog["img"]}.png";			
	}
	$blog["log"]=str_replace("\n","<br>",$blog["log"]);
	$blog["date"]=substr(str_replace("-",".",$blog["view_date"]),0,16);
}

$sql ="SELECT P.id, view_date, title, img, img_del, cast, genji,tag_name,tag_icon FROM wp00000_posts AS P";
$sql.=" LEFT JOIN wp00000_cast AS C ON P.cast=C.id";
$sql.=" LEFT JOIN wp00000_tag AS T ON P.tag=T.id";
$sql.=" WHERE P.status=0";
$sql.=" AND C.cast_status<4";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND C.id='{$blog["cast"]}'";
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

		if ($row["img"] && $row["img_del"]==0) {
			$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.png";			

		}else{
			$row["thumb"]="./img/blog_no_image.png";
		}

		$row["date"]=substr(str_replace("-",".",$row["view_date"]),0,10);
		$blog_new[]=$row;
		$blog_new_count++;
	}
}



$sql ="SELECT * FROM wp00000_sch_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_time[$row["in_out"]][$row["time"]]	=$row["name"];
	}
}


$t_day=date("Ymd",$day_time);
$n_day=date("Ymd",$day_time+(86400*7));

$sql	 ="SELECT * FROM wp00000_schedule";
$sql	.=" WHERE sche_date BETWEEN '{$t_day}' AND '{$n_day}'";
$sql	.=" AND cast_id='{$blog["cast"]}'";
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
		$list[$n]="<td class=\"schep_l_".$list_week."\">".$list_day." (".$week[$list_week].")</td><td class=\"schep_r_".$list_week."\"><span class=\"sche_block1\">".$tmp_s."</span>－<span class=\"sche_block1\">".$tmp_e."</span></td>";
	}else{
		$list[$n]="<td class=\"schep_l_".$list_week."\">".$list_day." (".$week[$list_week].")</td><td class=\"schep_r_".$list_week."\"><span class=\"sche_block1\">休み</span></td>";
	}
}


include_once('./header.php');
?>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<a href="./castblog.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">BLOG</span>
	</a>
	<span class="footmark_icon"></span>
	<a href="./castblog.php?cast_list=<?=$blog["cast"]?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text"><?=$blog["genji"]?></span>
	</a>

	<span class="footmark_icon pc_only"></span>
	<div class="footmark_box pc_only">
		<span class="footmark_icon"></span>
		<span class="footmark_text">『<?=$blog["title"]?>』</span>
	</div>
</div>
<div class="main_top_flex">
	<div class="main_article">
		<h1 class="blog_ttl">
			<?=$blog["title"]?>
		</h1>

		<div class="blog_ttl_btm">
			<span class="blog_ttl_tag"><span class="blog_list_icon"><?=$blog["tag_icon"]?></span><span class="blog_list_tcomm"><?=$blog["tag_name"]?></span></span>
			<span class="blog_ttl_date"><span class="icon"></span><?=$blog["date"]?></span>
		</div>
		<div class="blog_ttl_border">　</div>
		<?if($blog["thumb"]){?>
		<div class="blog_top_img"><img src="<?=$blog["thumb"]?>" class="blog_img"></div>
		<?}?>
		<div class="blog_log">
			<?=$blog["log"]?>
		</div>
	</div>

	<div class="sub_blog">
		<div class="sub_blog_pack_a">
			<div class="blog_title"><?=$blog["genji"]?></div>
			<div class="sub_blog_cast">
				<div class="blog_cast_left">
					<img src="<?=$blog["face"]?>" class="blog_cast_img">
					<a href="./person.php?post_id=<?=$blog["cast"]?>" class="blog_cast_link">Profile</a>
				</div>
				<table class="blog_cast_right">
					<?for($n=0;$n<7;$n++){?>
						<tr><?=$list[$n]?></tr>
					<?}?>
				</table>
			</div>
		</div>
		<div class="sub_blog_pack_b">

			<div class="blog_title">新着</div>
			<div class="sub_blog_in">
			<?for($s=0;$s<$blog_new_count;$s++){?>
				<a href="./article.php?post_id=<?=$blog_new[$s]["id"]?>" id="i<?=$b1?>" class="cast_blog">
					<img src="<?=$blog_new[$s]["thumb"]?>" class="person_blog_img">
					<span class="person_blog_tag"><span class="blog_list_icon"><?=$blog_new[$s]["tag_icon"]?></span><span class="blog_list_tcomm"><?=$blog_new[$s]["tag_name"]?></span></span>
					<span class="person_blog_date"><?=$blog_new[$s]["date"]?></span>
					<span class="person_blog_title"><?=$blog_new[$s]["title"]?></span>
				</a>
			<?}?>


			</div>
		</div>
	</div>
</div>
<?include_once('./footer.php'); ?>
