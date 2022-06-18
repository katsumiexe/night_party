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

$sql ="SELECT view_date, title, log, img, img_del, cast, tag_name, tag_icon, P.prm AS p_prm  FROM ".TABLE_KEY."_posts AS P";
$sql.=" LEFT JOIN ".TABLE_KEY."_tag AS T ON P.tag=T.id";
$sql.=" WHERE P.status=0";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND P.id='{$post_id}'";
$sql.=" AND P.cast=1";

if($result = mysqli_query($mysqli,$sql)){
	$blog = mysqli_fetch_assoc($result);

	if (file_exists("./img/profile/{$blog["cast"]}/0.webp") && $admin_config["webp_select"] == 1) {
		$blog["face"]="./img/profile/{$blog["cast"]}/0.webp?t={$blog["c_prm"]}";			

	}elseif (file_exists("./img/profile/{$blog["cast"]}/0.jpg")) {
		$blog["face"]="./img/profile/{$blog["cast"]}/0.jpg?t={$blog["c_prm"]}";

	}else{
		$blog["face"]="./img/cast_no_image.jpg";			
	}

	if ($blog["img"] && $blog["img_del"]==0) {
		if (file_exists("./img/profile/{$blog["cast"]}/{$blog["img"]}.webp") && $admin_config["webp_select"] == 1) {
			$blog["thumb"]="./img/profile/{$blog["cast"]}/{$blog["img"]}.webp?t={$blog["p_prm"]}";			

		}else{
			$blog["thumb"]="./img/profile/{$blog["cast"]}/{$blog["img"]}.png?t={$blog["p_prm"]}";		
		}
	}

	$blog["log"]=str_replace("\n","<br>",$blog["log"]);
	$blog["date"]=substr(str_replace("-",".",$blog["view_date"]),0,16);
}


$sql ="SELECT P.id, view_date, title, img, img_del, cast, tag_name,tag_icon, P.prm AS p_prm FROM ".TABLE_KEY."_posts AS P";
$sql.=" LEFT JOIN ".TABLE_KEY."_tag AS T ON P.tag=T.id";
$sql.=" WHERE P.status=0";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND P.cast='1'";
$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT 10";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if (file_exists("./img/profile/{$row["cast"]}/0.webp")) {
			$row["face"]="./img/profile/{$row["cast"]}/0.webp?t={$row["c_prm"]}";
			
		}elseif (file_exists("./img/profile/{$row["cast"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["cast"]}/0.jpg?t={$row["c_prm"]}";

		}else{
			$row["face"]="./img/cast_no_image.jpg";
		}

		if ($row["img"] && $row["img_del"]==0) {
			if (file_exists("./img/profile/{$row["cast"]}/{$row["img"]}_s.webp") && $admin_config["webp_select"] == 1) {
				$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.webp?t={$row["p_prm"]}";			

			}else{
				$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.png?t={$row["p_prm"]}";			
			}

		}else{
			$row["thumb"]="./img/blog_no_image.png";
		}

		$row["date"]=substr(str_replace("-",".",$row["view_date"]),0,10);
		$blog_new[]=$row;
		$blog_new_count++;
	}
}
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
	<a href="./castblog.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">EVENT</span>
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
		<div class="blog_title">新着</div>
		<div class="sub_blog_in">
		<?for($s=0;$s<$blog_new_count;$s++){?>
			<a href="./article.php?post_id=<?=$blog_new[$s]["id"]?>" id="i<?=$b1?>" class="cast_blog">
				<img src="<?=$blog_new[$s]["thumb"]?>" class="person_blog_img">
				<span class="person_blog_date"><?=$blog_new[$s]["date"]?></span>
				<span class="person_blog_title"><?=$blog_new[$s]["title"]?></span>
			</a>
		<?}?>
		</div>
	</div>

</div>
<?include_once('./footer.php'); ?>
