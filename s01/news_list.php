<?php
include_once('./library/sql.php');

$code=$_REQUEST["code"];

if($code){
	$app=" AND tag='{$code}'";
}

$sel_year=$_POST["now_year"];
if(!$sel_year) $sel_year=date("Y");

$now_year		=date("Y");
$start_year		=date("Y");

$sel=$_POST["sel"]+0;

$open_day=substr($admin_config["open_day"],0,4)."-".substr($admin_config["open_day"],4,2)."-".substr($admin_config["open_day"],6,2);

$sql	 ="SELECT tag_name, tag, tag_icon, `display_date`,event_date, category, contents_key, title, contents FROM wp00000_contents";
$sql	.=" LEFT JOIN wp00000_tag ON tag=wp00000_tag.id";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND `event_date`>='{$open_day}'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY `event_date` DESC";

if($res1 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res1)){

		$a1["news_date"]=str_replace("-",".",$a1["event_date"]);
		if($a1["category"] == "person"){
			$a1["news_link"]="./person.php?post_id={$a1["contents_key"]}";

		}elseif($a1["category"] == "outer"){
			$a1["news_link"]=$a1["contents_key"];

		}elseif($a1["category"] == "event"){
			$a1["news_link"]="./event.php?post_id={$a1["contents_key"]}";
		}
		
		$news[]=$a1;
		$count_news++;
	}
}

$sql	 ="SELECT * FROM wp00000_tag";
$sql	.=" WHERE tag_group='news'";
$sql	.=" AND del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[]=$row;
		$count_tag++;
	}
}
include_once('./header.php');
?>
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
</div>
<div class="main_top_flex">
	<div class="news_main_a">
		<div class="main_b_top">
			<?for($n=0;$n<$count_news;$n++){?>
				<?if($news[$n]["contents_url"]){?>
					<table class="main_b_notice tag<?=$news[$n]["tag"]?>">">
						<tr>
							<td  class="main_b_td_1">
								<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
								<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
							</td>
							<td  class="main_b_td_2">
								<a href="<?=$news[$n]["contents_url"]?>" class="main_b_notice_link">
									<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
								</a>
							</td>
							<td  class="main_b_td_3">
								<span class="main_b_notice_arrow"><a href="<?=$news[$n]["contents_url"]?>" class="main_b_notice_alink">	</a></span>
							</td>
						</tr>
					</table>

				<?}elseif($news[$n]["category"]){?>

					<table  class="main_b_notice tag<?=$news[$n]["tag"]?>">">
						<tr>
							<td  class="main_b_td_1">
								<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
								<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
							</td>
							<td  class="main_b_td_2">
								<a href="<?=$news[$n]["category"]?>.php?post_id=<?=$news[$n]["contents_key"]?>" class="main_b_notice_link">
									<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
								</a>
							</td>
							<td class="main_b_td_3">
								<span class="main_b_notice_arrow"><a href="<?=$news[$n]["category"]?>.php?post_id=<?=$news[$n]["contents_key"]?>" class="main_b_notice_alink">	</a></span>
							</td>
						</tr>
					</table>
				<?}else{?>
					<table class="main_b_notice tag<?=$news[$n]["tag"]?>">
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
	<div class="news_main_b">
		<div class="news_main_b_year">
			<?if($now_year > $start_year){?>
				<form id="form_year" method="post">
					<select id="sel_year" name="now_year" class="sel_year">
						<?for($n=$start_year;$n<$now_year+1;$n++){?>
							<option value="<?=$n?>" <?if($sel_year == $n){?>selected="selcted"<?}?>><?=$n?></option>
						<?}?>
					</select>
					<input id="sel" type="hidden" name="sel" value="0">
				</form>
			<?}?>
		</div>
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
