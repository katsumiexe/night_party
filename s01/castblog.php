<?php
include_once('./library/sql.php');

$pg=$_REQUEST["pg"];
if($pg+0<1) $pg=1;

$pg_st=($pg-1)*16;
$pg_ed=($pg-1)*16+16;

$blog_day	=$_REQUEST["blog_day"];
$cast_list	=$_REQUEST["cast_list"];
$tag_list	=$_REQUEST["tag_list"];
$month		=$_REQUEST["month"];

$n=0;

if($blog_day) $month=substr($blog_day,0,6);
if(!$month) $month=substr($day_8,0,6);

//■カレンダーカウント
$sql ="SELECT view_date FROM wp00000_posts";
$sql.=" WHERE status=0";
$sql.=" AND view_date LIKE '".substr($month,0,4)."-".substr($month,4,2)."%'";
$sql.=" AND view_date<='{$now}'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmp=substr($row["view_date"],8,2)+0;
		$calendar_ck[$tmp]=1;
	}
}

//■ブログ件数カウント
$sql ="SELECT  COUNT(P.id) AS cnt FROM wp00000_posts AS P";
$sql.=" LEFT JOIN wp00000_cast AS C ON P.cast=C.id";

$sql.=" WHERE status=0";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND cast_status=0";
if($cast_list){
	$sql.=" AND cast='{$cast_list}'";
	$ap_link="&cast_list={$cast_list}";
}

if($tag_list){
	$sql.=" AND tag='{$tag_list}'";
	$ap_link="&tag_list={$tag_list}";
}

if($blog_day){
	$sql.=" AND view_date LIKE '".substr($blog_day,0,4)."-".substr($blog_day,4,2)."-".substr($blog_day,6,2)."%'";
	$ap_link="&blog_day={$blog_day}";
}
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$blog_count=$row["cnt"];
	}
}

//■キャスト件数カウント
$sql ="SELECT cast, genji, COUNT(wp00000_posts.id) AS cnt ,MAX(view_date) AS b_date FROM wp00000_posts";
$sql.=" LEFT JOIN wp00000_cast ON wp00000_posts.cast=wp00000_cast.id";
$sql.=" WHERE status=0";
$sql.=" AND cast_status=0";
$sql.=" AND view_date<='{$now}'";
$sql.=" GROUP BY cast";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$cast_dat[$a1["cast"]]["cnt"]	=$a1["cnt"];
		$cast_dat[$a1["cast"]]["name"]	=$a1["genji"];
		$cast_dat[$a1["cast"]]["date"]	=str_replace("-",".",substr($a1["b_date"],0,16));

		if (file_exists("./img/profile/{$a1["cast"]}/0_s.webp")) {
			$cast_dat[$a1["cast"]]["face"]	="./img/profile/{$a1["cast"]}/0_s.webp";

		}elseif (file_exists("./img/profile/{$a1["cast"]}/0_s.jpg")) {
			$cast_dat[$a1["cast"]]["face"]	="./img/profile/{$a1["cast"]}/0_s.jpg";

		}else{
			$cast_dat[$a1["cast"]]["face"]	="./img/cast_no_image.jpg";
		}
	}
}

//■カテゴリ件数カウント
$sql ="SELECT tag_name, tag_icon, wp00000_tag.id, COUNT(wp00000_posts.id) AS cnt FROM wp00000_tag";
//$sql ="SELECT wp00000_posts.id AS pid, tag_name, tag_icon, wp00000_tag.id FROM wp00000_tag";
$sql.=" LEFT JOIN wp00000_posts ON wp00000_tag.id=wp00000_posts.tag";
$sql.=" LEFT JOIN wp00000_cast ON wp00000_posts.cast=wp00000_cast.id";
$sql.=" WHERE tag_group='blog'";
$sql.=" AND (status=0 OR status IS NULL)";
$sql.=" AND (view_date<='{$now}' OR view_date IS NULL)";
$sql.=" AND cast_status=0";
$sql.=" GROUP BY wp00000_tag.id";
$sql.=" ORDER BY sort ASC";
//$sql.=" ORDER BY pid ASC";


if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$tag_count[$a1["id"]]	=$a1;
		$cate_all+=$a1["cnt"];
	}
}

$pg_max=ceil($blog_count/16);

if($pg_max<=5 && $pg_max>1){
	$p_list.="<div class=\"page_box\">";
		for($pp=1;$pp<$pg_max+1;$pp++){
			$p_list.="<a href=\"castblog.php?pg={$pp}{$ap_link}\" class=\"page_n ";
			if($pp==$pg) $p_list.="pg_n";
			$p_list.="\">{$pp}</a>";
		}
	$p_list.="</div>";

}elseif($pg_max>5){

	if($pg<3){
		$pg_s=1;
		$pg_e=5;

	}elseif($pg_max-$pg<2){
		$pg_e=$pg_max;
		$pg_s=$pg_max-5;
	
	}else{
		$pg_s=$pg-2;
		$pg_e=$pg+2;
	}

	$p_list.="<div class=\"page_box\">";
		$p_list.="<a href=\"castblog.php?pg=1{$ap_link}\" class=\"page_n pg_f\">«</a>";
		for($pp=$pg_s;$pp<$pg_e+1;$pp++){
			$p_list.="<a href=\"castblog.php?pg={$pp}{$ap_link}\" class=\"page_n ";
			if($pp==$pg) $p_list.="pg_n";
			$p_list.="\">{$pp}</a>";
		}
		$p_list.="<a href=\"castblog.php?pg={$pg_max}{$ap_link}\" class=\"page_n pg_b\">»</a>";
	$p_list.="</div>";
}

$sql ="SELECT P.id,view_date, title, img, img_del, cast, genji,tag_name,tag_icon FROM wp00000_posts AS P";
$sql.=" LEFT JOIN wp00000_cast AS C ON P.cast=C.id";
$sql.=" LEFT JOIN wp00000_tag AS T ON P.tag=T.id";

$sql.=" WHERE P.status=0";
$sql.=" AND C.cast_status=0";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND P.log<>''";
$sql.=" AND P.title<>''";


if($cast_list){
	$sql.=" AND cast='{$cast_list}'";
}

if($tag_list){
	$sql.=" AND tag='{$tag_list}'";
}
if($blog_day){
	$sql.=" AND view_date LIKE '".substr($blog_day,0,4)."-".substr($blog_day,4,2)."-".substr($blog_day,6,2)."%'";

}

$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT {$pg_st},16";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if (file_exists("./img/profile/{$row["cast"]}/0.webp")) {
			$row["face"]="./img/profile/{$row["cast"]}/0.webp";

		}elseif (file_exists("./img/profile/{$row["cast"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["cast"]}/0.jpg";

		}else{
			$row["face"]="./img/cast_no_image.jpg";
		}

		if ($row["img"] && $row["img_del"]==0 ) {
			$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.png";

		}else{
			$row["thumb"]="./img/blog_no_image.png";
		}


		$row["date"]=substr(str_replace("-",".",$row["view_date"]),0,16);
		$blog[]	=$row;
		$count_blog++;
	}
}

$v_month=date("Y年m月",strtotime($month."01"));
$p_month=date("Ym",strtotime($month."01")-86400);
$n_month=date("Ym",strtotime($month."01")+3456000);
$month_w=date("w",strtotime($month."01"))-1;
$month_e=date("t",strtotime($month."01"));
$month_max=ceil(($month_w+$month_e)/7)*7;

for($n=0;$n<$month_max ;$n++){
	if($n % 7 == 0){
		$c_inc.="</tr><tr>";
	}
	$tmp_days=$n-$month_w;
	if($n>$month_w && $n<=$month_w+$month_e){
		$ky=$month*100+$tmp_days;
		if($calendar_ck[$tmp_days]){
			$c_inc.="<td class=\"blog_calendar_d\"><a href=\"castblog.php?blog_day={$ky}\" class=\"cal1\">{$tmp_days}</a></td>";
		
		}else{
			$c_inc.="<td class=\"blog_calendar_d\"><span class=\"cal\">{$tmp_days}<span></td>";
		}

	}else{
		$c_inc.="<td class=\"blog_calendar_d\"></td>";
	}
}
include_once('./header.php');
?>


<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>

<?if($cast_list){?>
	<span class="footmark_icon"></span>
	<a href="./castblog.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">blog</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text"><?=$blog[0]["genji"]?></span>
	</div>

<?}elseif($tag_list){?>
	<span class="footmark_icon"></span>
	<a href="./castblog.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">blog</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"><?=$tag_count[$tag_list]["tag_icon"]?></span>
		<span class="footmark_text"><?=$tag_count[$tag_list]["tag_name"]?></span>
	</div>

<?}else{?>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">blog</span>
	</div>
<?}?>
</div>

<div class="main_top_flex">
	<div class="main_flex_a">
		<h2 class="main_blog_title"> Cast Blog</h2>

		<div class="main_article">
			<?for($n=0;$n<$count_blog+0;$n++){?>
				<a href="./article.php?post_id=<?=$blog[$n]["id"]?>" id="i<?=$n?>" class="blog_list">
					<img src="<?=$blog[$n]["thumb"]?>" class="blog_list_img">
					<span class="blog_list_comm">
						<span class="blog_list_i"></span>
						<span class="blog_list_c"><?=$blog[$n]["count"]+0?></span>
					</span>
					<span class="blog_list_title"><?=$blog[$n]["title"]?></span>
					<span class="blog_list_cast">
						<span class="blog_list_tag">
							<span class="blog_list_icon"><?=$blog[$n]["tag_icon"]?></span>
							<span class="blog_list_tcomm"><?=$blog[$n]["tag_name"]?></span>
						</span>
						<span class="blog_list_date"><?=$blog[$n]["date"]?></span>
						<span class="blog_list_castname"><?=$blog[$n]["genji"]?></span>
						<span class="blog_list_frame_a">
							<img src="<?=$blog[$n]["face"]?>?t=<?=time()?>" class="blog_list_castimg">
						</span>
					</span>
				</a>
			<? } ?>
			<?if($count_blog<1){?>
				<span class="no_blog">まだありません</span>
			<? } ?>
		</div>
		<?=$p_list?>
	</div>
	<div class="main_flex_b">
		<table id="c" class="blog_calendar">
			<tr>
				<td id="c_prev"class="blog_calendar_n"><a href="./castblog.php?month=<?=$p_month?><?=$c_para?><?=$t_para?>" class="carendar_pn"></a></td>
				<td class="blog_calendar_m" colspan="5"><?=$v_month?></td>
				<td id="c_next" class="blog_calendar_n"><a href="./castblog.php?month=<?=$n_month?><?=$c_para?><?=$t_para?>" class="carendar_pn"></a></td>
			</tr>
			<tr>
				<td class="blog_calendar_w">日</td>
				<td class="blog_calendar_w">月</td>
				<td class="blog_calendar_w">火</td>
				<td class="blog_calendar_w">水</td>
				<td class="blog_calendar_w">木</td>
				<td class="blog_calendar_w">金</td>
				<td class="blog_calendar_w">土</td>
				<?=$c_inc?>
			</tr>
		</table>

		<div class="sub_blog">
			<?if($tag_count){?>
			<div class="sub_blog_in">
				<div class="blog_h1">カテゴリー</div>
				<a href="./castblog.php" class="all_tag">
					<span class="all_tag_icon"></span>
					<span class="all_tag_name">全て</span>
					<span class="all_tag_count"><?=$cate_all?></span>
				</a>

				<?foreach($tag_count as $a1=> $a2){?>
				<a href="./castblog.php?tag_list=<?=$a1?>" class="all_tag">
					<span class="all_tag_icon"><?=$a2["tag_icon"]?></span>
					<span class="all_tag_name"><?=$a2["tag_name"]?></span>
					<span class="all_tag_count"><?=$a2["cnt"]?></span>
				</a>
				<? } ?>
			</div>
			<?}?>

			<?if($cast_dat){?>
			<div class="sub_blog_in">
				<div class="blog_h1">CAST一覧</div>
				<?foreach($cast_dat as $a1=> $a2){?>
					<a href="./castblog.php?cast_list=<?=$a1?>" class="all_cast">
						<span class="all_cast_img"><img src="<?=$cast_dat[$a1]["face"]?>?t=<?=time()?>" class="all_cast_img_in"></span>
						<span class="all_cast_name"><?=$cast_dat[$a1]["name"]?></span>
						<span class="all_cast_last"><?=$cast_dat[$a1]["date"]?> 更新</span>
						<span class="all_cast_count"><?=$cast_dat[$a1]["cnt"]?></span>
					</a>
				<?}?>
			</div>
			<?}?>
		</div>
	</div>
</div>
</div>
<?include_once('./footer.php'); ?>
