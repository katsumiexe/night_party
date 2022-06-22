<?php
include_once('./library/sql.php');

$h_time=$admin_config["start_time"]*100;
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
		$sch_sort[$row["in_out"]][$row["time"]]	=$row["sort"];
	}
}
$sql="SELECT MAX(id) AS tmp, cast_id FROM ".TABLE_KEY."_schedule ";
$sql.="WHERE sche_date='{$day_8}' ";
$sql.="GROUP BY cast_id";

if($result = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($result)){

		$sql2=" SELECT S.id, S.stime, S.etime, S.cast_id, C.genji, C.prm, C.genji, C.ctime, C.ribbon_use, C.cast_ribbon, C.prm FROM ".TABLE_KEY."_schedule AS S";
		$sql2.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON C.id = S.cast_id";
		$sql2.=" WHERE S.id='{$row0["tmp"]}'";
		$sql2.=" AND S.stime<>''";
		$sql2.=" AND S.etime<>''";
		$sql2.=" AND C.genji IS NOT NULL";

		if($result2 = mysqli_query($mysqli,$sql2)){
			while($row = mysqli_fetch_assoc($result2)){
				if($row["stime"] && $row["etime"] ){
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

					if (file_exists("./img/profile/{$row["cast_id"]}/0.webp")) {
						$row["face"]="./img/profile/{$row["cast_id"]}/0.webp?t={$row["prm"]}";

					}elseif (file_exists("./img/profile/{$row["cast_id"]}/0.jpg")) {
						$row["face"]="./img/profile/{$row["cast_id"]}/0.jpg?t={$row["prm"]}";

					}elseif (file_exists("./img/profile/{$row["cast_id"]}/0.png")) {
						$row["face"]="./img/profile/{$row["cast_id"]}/0.png?t={$row["prm"]}";

					}else{
						$row["face"]="./img/cast_no_image.jpg";			
					}

					$row["sch"]=$sch_time["in"][$row["stime"]]." - ".$sch_time["out"][$row["etime"]];

					if($h_time>$row["stime"]){
						$tmp=($row["stime"]+2400)*10000000;
					}else{
						$tmp=($row["stime"])*1000000;
					}

					if($h_time>$row["etime"]){
						$tmp+=($row["etime"]+2400)*10000;
					}else{
						$tmp+=($row["etime"])*10000;
					}

					$tmp+=$row["id"];
					$cast_dat[$tmp]=$row;
				}
			}
		}
	}
}
if($cast_dat){
ksort($cast_dat);
}
$sql	 ="SELECT * FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE status=0";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='event'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 6";

if($res0 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res0)){

		if($a1["category"] == "event"){
			$a1["link"]="./event.php";
			$a1["code"]=$a1["id"];

		}elseif($a1["category"] == "person"){
			$a1["link"]="./person.php";
			$a1["code"]=$a1["contents_key"];

		}elseif($a1["category"]){
			$a1["link"]=$a1["contents_key"];
		}

		if (file_exists("./img/page/event/event_{$a1["id"]}.webp") && $admin_config["webp_select"] == 1) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.webp?t={$a1["prm"]}";

		}elseif (file_exists("./img/page/event/event_{$a1["id"]}.jpg")) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.jpg?t={$a1["prm"]}";

		}elseif (file_exists("./img/page/event/event_{$a1["id"]}.png")) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.png?t={$a1["prm"]}";
		}
		$event[]=$a1;
		$count_event++;
	}
}

$sql	 ="SELECT tag_name, tag_icon, date, status, display_date,event_date, category, contents_key, title, contents FROM ".TABLE_KEY."_contents";
$sql	.=" LEFT JOIN ".TABLE_KEY."_tag ON tag=".TABLE_KEY."_tag.id";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY status DESC, event_date DESC";
$sql	.=" LIMIT 5";


if($res1 = mysqli_query($mysqli,$sql)){
	while($a2 = mysqli_fetch_assoc($res1)){
		$a2["date"]=substr(str_replace("-",".",$a2["event_date"]),0,10);

		if($a2["status"] ==2){
			$a2["caution"]="news_caution";
		} 

		if($a2["category"] == "person"){
			$a2["news_link"]="./person.php?post_id={$a2["contents_key"]}";

		}elseif($a2["category"] == "outer"){
			$a2["news_link"]=$a2["contents_key"];

		}elseif($a2["category"] == "event"){
			$a2["news_link"]="./event.php?post_id={$a2["contents_key"]}";

		}elseif($a2["category"] == "blog"){
			$a2["news_link"]="./article.php?post_id={$a2["contents_key"]}";

		}elseif($a2["category"] == "page"){
			$a2["news_link"]=$a2["contents_key"];
		}
		$news[]=$a2;
		$count_news++;
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE status<4";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='info'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 6";

if($res2 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res2)){

		if($a1["category"] == "person" && $a1["contents_key"]){
			$a1["link"]="person.php?post_id=".$a1["contents_key"];

		}elseif($a1["category"] == "event" && $a1["contents_key"]){
			$a1["link"]="event.php?post_id=".$a1["contents_key"];

		}elseif($a1["contents_key"]){
			$a1["link"]=$a1["contents_key"];
		}

		if (file_exists("./img/page/info/info_{$a1["id"]}.webp") && $admin_config["webp_select"] == 1) {
			$a1["img"]="./img/page/info/info_{$a1["id"]}.webp?t={$a1["prm"]}";

		}elseif (file_exists("./img/info/info_/event_{$a1["id"]}.jpg")) {
			$a1["img"]="./img/page/info/info_{$a1["id"]}.jpg??t={$a1["prm"]}";

		}elseif (file_exists("./img/info/info_/event_{$a1["id"]}.png")) {
			$a1["img"]="./img/page/info/info_{$a1["id"]}.png??t={$a1["prm"]}";
		}
		$info[]=$a1;
		$info_count++;
	}
}
include_once('./header.php');
?>
<style>
#slide_img0{
	left			:0;
	z-index			:1;
}

#slide_img1{
	z-index			:2;
}
</style>
<script>
var Cnt=<?=$count_event?>;
var NewCnt=1;
</script>
<form id="form_1" method="get" action="">
<input id="s_code" type="hidden" name="post_id">
</form>
<script src="./js/index.js"></script>
<section class="main_top">
<?if($count_event==1){?>
	<div class="slide">
		<div class="slide_img">
			<?if($event[0]["link"]){?>
			<a href="<?=$event[0]["link"]?>?post_id=<?=$event[0]["code"]?>">
				<img src="<?=$event[0]["img"]?>" class="top_img_in" alt="<?=$event[0]["title"]?>">;
			</a>
			<?}else{?>
				<img src="<?=$event[0]["img"]?>" class="top_img_in" alt="<?=$event[0]["title"]?>">;
			<?}?>
		</div>
	</div>

<?}elseif($count_event >1){?>
	<div class="slide">
		<div class="slide_img">
			<?for($n=0;$n<$count_event;$n++){?>
				<div id="slide_img<?=$n?>" s_link="<?=$event[$n]["link"]?>" s_code="<?=$event[$n]["code"]?>" class="top_img">
				<img src="<?=$event[$n]["img"]?>" class="top_img_in" alt="<?=$event[$n]["title"]?>">;
				</div>
			<?}?>	
			<div class="slide_img_cv"></div>
		</div>

		<span class="slide_point">
			<?for($n=0;$n<$count_event;$n++){?>
				<div id="dot<?=$n?>" class="slide_dot<?if($n == 0){?> dot_on<?}?>"></div>
			<?}?>
		</span>
	</div>
<?}?>

	<div class="main_b">
		<?if($count_news){?>
		<h2 class="main_b_title">新着情報<a href="./news_list.php" class="news_all">一覧</a><div class="news_al">　</div></h2>
 
		<div class="main_b_top">
			<?for($n=0;$n<$count_news;$n++){?>
				<?if($news[$n]["category"]){?>
					<table class="main_b_notice <?=$news[$n]["caution"]?>">
					<tr>
						<td  class="main_b_td_1">
							<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
							<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
						</td>

						<td  class="main_b_td_2">
							<a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_link">
								<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
							</a>
						</td>
						<td class="main_b_td_3"><a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_arrow">	</a></td>
					</tr>
					</table>

				<?}else{?>
					<table class="main_b_notice <?=$news[$n]["caution"]?>">
						<tr>
							<td  class="main_b_td_1">
								<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
								<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
							</td>
							<td  class="main_b_td_2">
								<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
							</td>
						</tr>
					</table>
				<?}?>
			<?}?>
		</div>
		<?}?>

		<h2 class="main_b_title">本日の出勤キャスト</h2>
		<div class="main_b_in">
			<?if(is_array($cast_dat)){?>
				<? foreach($cast_dat as $b1 => $b2){?>
					<span class="main_b_1">
						<div class="main_b_1_1" style="background-image:url('<?=$b2["face"]?>')"></div>

						<span class="main_b_1_2">
							<span class="main_b_1_2_h"></span>
							<span class="main_b_1_2_f f_tr"></span>
							<span class="main_b_1_2_f f_tl"></span>
							<span class="main_b_1_2_f f_br"></span>
							<span class="main_b_1_2_f f_bl"></span>
							<span class="main_b_1_2_name"><?=$b2["genji"]?></span>
							<span class="main_b_1_2_sch"><?=$b2["sch"]?></span>
						</span>
						<?if($b2["ribbon_name"]){?>
							<span class="main_b_1_ribbon" style="background:linear-gradient(<?=$b2["ribbon_c1"]?>,<?=$b2["ribbon_c2"]?>);box-shadow	:0 -5px 0 <?=$b2["ribbon_c1"]?>,0 5px 0 <?=$b2["ribbon_c2"]?>;"><?=$b2["ribbon_name"]?></span>
						<?}?>
					<a href="./person.php?post_id=<?=$b2["cast_id"]?>" id="i<?=$b1?>" class="main_b_1_0"></a>
					</span>
				<? } ?>
			<? }else{ ?>
				<span class="no_blog">予定はありません</span>
			<? } ?>
		</div>
	</div>

 	<div class="main_c">
		<div class="info_box">
			<?for($n=0;$n<$info_count;$n++){?>
				<?if($info[$n]["link"]){?>
					<a href="<?=$info[$n]["link"]?>" class="info_img_out">
						<img src="<?=$info[$n]["img"]?>" class="info_img">
					</a>
				<?}else{?>	
						<img src="<?=$info[$n]["img"]?>" class="info_img">
				<?}?>
			<?}?>
		</div>
		<?if($admin_config["twitter_view"]==1 && $admin_config["twitter"]){?>
			<div class="twitter_title" style="text-align:center">◆　twitter　◆</div>
			<div class="twitter_tl"><a class="twitter-timeline" data-width="300" data-height="500" data-theme="dark" data-chrome="noscrollbar,transparent,noheader,nofooter" style="width:100%" href="https://twitter.com/<?=$admin_config["twitter"]?>?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			</div>
			<div class="twitter_foot"><a href="https://twitter.com/<?=$admin_config["twitter"]?>" class="twitter_foot_in"><span class="twitter_icon"></span>フォローする</a></div>
		<?}?>
	</div>
</section>
<?include_once('./footer.php'); ?>