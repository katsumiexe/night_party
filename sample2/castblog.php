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
$sql ="SELECT view_date FROM ".TABLE_KEY."_posts";
$sql.=" WHERE status=0";
$sql.=" AND view_date LIKE '".substr($month,0,4)."-".substr($month,4,2)."%'";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND cast>0";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmp=substr($row["view_date"],8,2)+0;
		$calendar_ck[$tmp]=1;
	}
}


//■ブログ件数カウント
$sql ="SELECT  COUNT(P.id) AS cnt FROM ".TABLE_KEY."_posts AS P";
$sql.=" WHERE status=0";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND cast=1";
$sql.=" AND log<>''";
$sql.=" AND title<>''";

if($blog_day){
	$sql.=" AND view_date LIKE '".substr($blog_day,0,4)."-".substr($blog_day,4,2)."-".substr($blog_day,6,2)."%'";
	$ap_link="&blog_day={$blog_day}";
}

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$blog_count=$row["cnt"];
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

$sql ="SELECT P.id,view_date, title, img, img_del, cast, log, tag_name, tag_icon FROM ".TABLE_KEY."_posts AS P";
$sql.=" LEFT JOIN ".TABLE_KEY."_tag AS T ON P.tag=T.id";

$sql.=" WHERE P.status=0";
$sql.=" AND P.cast=1";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND P.log<>''";
$sql.=" AND P.title<>''";

if($blog_day){
	$sql.=" AND view_date LIKE '".substr($blog_day,0,4)."-".substr($blog_day,4,2)."-".substr($blog_day,6,2)."%'";
}

$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT {$pg_st},16";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if ($row["img"] && $row["img_del"]==0 ) {
			if (file_exists("./img/profile/{$row["cast"]}/{$row["img"]}_s.webp") && $admin_config["webp_select"] == 1) {
				$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.webp";

			}else{
				$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.png";
			}

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


$inc_title="｜イベント情報";
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
		<span class="footmark_icon"></span>
		<span class="footmark_text">EVENT</span>
	</div>
</div>

<article class="main_top_flex">
	<h2 class="box_title">
	<span class="title_main">EVENT</span>
	<span class="title_sub">イベント</span>
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
	<div class="main_blog_list">
		<?for($n=0;$n<$count_blog+0;$n++){?>
			<a href="./article.php?post_id=<?=$blog[$n]["id"]?>" id="i<?=$n?>" class="blog_list">
				<img src="<?=$blog[$n]["thumb"]?>" class="blog_list_img">
				<span class="blog_list_title"><span class="blog_list_title_in"><?=$blog[$n]["title"]?></span></span>
				<span class="blog_list_log"><?=$blog[$n]["log"]?></span>
				<span class="blog_list_date"><?=$blog[$n]["date"]?></span>
				<span class="blog_list_more"> Read More 》</span>
			</a>
		<? } ?>
		<?if($count_blog<1){?>
			<span class="no_blog">まだありません</span>
		<? } ?>
	</div>
	<?=$p_list?>
</article>
</div>
<?include_once('./footer.php'); ?>
