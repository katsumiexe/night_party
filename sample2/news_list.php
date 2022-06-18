<?php
include_once('./library/sql.php');

$code=$_REQUEST["code"];

if($code){
	$app=" AND tag='{$code}'";
}

$sel_year=$_POST["sel_year"];
if(!$sel_year) $sel_year=date("Y");
$now_year		=date("Y");

$start_year=substr($admin_config["open_day"],0,4);
$sel=$_POST["sel"]+0;
$open_day=substr($admin_config["open_day"],0,4)."-".substr($admin_config["open_day"],4,2)."-".substr($admin_config["open_day"],6,2);

$sql	 ="SELECT tag_name, tag, tag_icon, `display_date`,event_date, category, contents_key, title, contents FROM ".TABLE_KEY."_contents";
$sql	.=" LEFT JOIN ".TABLE_KEY."_tag ON tag=".TABLE_KEY."_tag.id";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND `event_date`>='{$sel_year}-01-01'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY `event_date` DESC";

if($res1 = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($res1)){

		$row["news_date"]=str_replace("-",".",$row["event_date"]);

		if($a2["status"] ==2){
			$a2["caution"]="news_caution";
		} 

		if($row["category"] == "person"){
			$row["news_link"]="./person.php?post_id={$row["contents_key"]}";

		}elseif($row["category"] == "outer"){
			$row["news_link"]=$row["contents_key"];

		}elseif($row["category"] == "event"){
			$row["news_link"]="./event.php?post_id={$row["contents_key"]}";
		}
		
		$news[]=$row;
		$count_news++;
	}
}

$sql	 ="SELECT substring(event_date, 1,4) AS gp_date, count(id) AS cnt FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='news'";
$sql	.=" GROUP BY gp_date";

if($res1 = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($res1)){
		$hist_log[$row["gp_date"]]=$row["cnt"];
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE tag_group='news'";
$sql	.=" AND del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[]=$row;
		$count_tag++;
	}
}

$inc_title="｜過去のニュース一覧";
include_once('./header.php');
?>
</header>
<div class="main">
<style>
<?if($sel > 0){?>
.main_b_notice{
	display:none;
}

.tag<?=$sel?>{
	display:block !important;
}
<?}?>
</style>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">NEWS</span>
	</div>

	<select id="sel_year" name="sel_year" class="sel_news_year">
		<?foreach($hist_log as $a1 => $a2){?>
			<option value="<?=$a1?>" <?if($sel_year == $a1){?>selected="selcted"<?}?>><?=$a1?>年(<?=$a2?>件)</option>
		<?}?>
	</select>
	<input id="sel" type="hidden" name="sel" value="0">
</div>


<div class="main_top_flex">
	<div class="news_a">
		<div class="main_b_title pc_only">NEWS</div>
		<div class="main_b_top">
			<?for($n=0;$n<$count_news;$n++){?>
				<?if($news[$n]["category"]){?>
					<table  class="main_b_notice tag<?=$news[$n]["tag"]?>"> <?=$news[$n]["caution"]?>">
						<tr>
							<td  class="main_b_td_1">
								<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
								<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
							</td>
							<td  class="main_b_td_2">
								<a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_link">
									<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
								</a>
							</td>
							<td class="main_b_td_3">
								<span class="main_b_notice_arrow"><a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_link">	</a></span>
							</td>
						</tr>
					</table>

				<?}else{?>
					<table  class="main_b_notice tag<?=$news[$n]["tag"]?>"> <?=$news[$n]["caution"]?>">
						<tr>
							<td  class="main_b_td_1">
								<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
								<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
							</td>
							<td  class="main_b_td_2">
								<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
							</td>
						</tr>
					</table>
				<?}?>
			<?}?>

			<div class="no_news">まだありません</div>
		</div>
	</div>
	<div class="news_b">
		<?if($tag){?>
			<div class="news_tag">
					<div id="tag0" class="news_tag_list<?if($sel+0== 0){?> cast_tag_box_sel<?}?>">全て</div>
				<?for($n=0;$n<$count_tag;$n++){?>
					<div id="tag<?=$tag[$n]["id"]?>" class="news_tag_list<?if($sel+0== $tag[$n]["id"]){?> cast_tag_box_sel<?}?>"><?=$tag[$n]["tag_name"]?></div>
				<?}?>
			</div>
		<?}?>
	</div>
</div>
<br>
<?include_once('./footer.php'); ?>
